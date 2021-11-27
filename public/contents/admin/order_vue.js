if (document.getElementById('order_list')) {
    const app = new Vue({
        el: '#order_list',
        data: function(){
            return {
                orders: {},
                type: 'all',
                search_key: '',
            }
        },
        created: function(){
            this.get_orders();
        },
        methods: {
            search_orders: function(page=1){
                axios.get('/orders/get-all?page='+page+`&search=${this.search_key}`)
                    .then((res)=>{
                        // console.log(res);
                        this.orders = res.data;
                        let that = this;
                        setTimeout(() => {
                            that.get_change_status_id();
                        }, 500);
                    })
            },
            get_orders: function(page=1){
                axios.get('/orders/get-all?page='+page+`&type=${this.type}`)
                    .then((res)=>{
                        // console.log(res);
                        this.orders = res.data;
                        let that = this;
                        setTimeout(() => {
                            that.get_change_status_id();
                        }, 500);
                    })
            },
            get_by_type: function(type){
                this.type = type;
                this.get_orders();
            },
            get_order_status: function(status){
                if(status <= 2){
                    return `<span class="badge bg-primary">pending</span>`;
                }
                else if(status == 3){
                    return '<span class="badge bg-secondary">accepted</span>';
                }
                else if(status == 4){
                    return '<span class="badge bg-success">processing</span>';
                }
                else if(status == 5){
                    return '<span class="badge bg-warning">delivered</span>';
                }
                else if(status == 6){
                    return '<span class="badge bg-danger">canceled</span>';
                }else{
                    return '';
                }
            },
            get_change_status: function(status,id,index){
                if(status <= 2){
                    return `
                        <a href="#" data-id="${id}" data-change_to="3" data-index="${index}" class="btn status-btn btn-primary btn-sm p-1">
                            <i class="fa fa-plus"></i>
                            <span>accept</span>
                        </a>
                    `;
                }
                else if(status == 3){
                    return `
                        <a href="#" data-id="${id}" data-change_to="4" data-index="${index}" class="btn status-btn btn-secondary btn-sm p-1">
                            <i class="fa fa-plus"></i>
                            <span>Process</span>
                        </a>
                    `;
                }
                else if(status == 4){
                    return `
                        <a href="#" data-id="${id}" data-change_to="5" data-index="${index}" class="btn status-btn btn-warning btn-sm p-1">
                            <i class="fa fa-plus"></i>
                            <span>Deliver</span>
                        </a>
                    `;
                }
                else if(status == 5){
                    return `
                        <a href="#" data-id="${id}" data-change_to="6" data-index="${index}" class="btn status-btn btn-danger btn-sm p-1">
                            <i class="fa fa-plus"></i>
                            <span>Cancel</span>
                        </a>
                    `;
                }
                else if(status == 6){
                    return `
                        <a href="#" data-id="${id}" data-change_to="4" data-index="${index}" class="btn status-btn btn-info btn-sm p-1">
                            <i class="fa fa-plus"></i>
                            <span>Recover to process</span>
                        </a>
                    `;
                }
                else{
                    return '';
                }
            },
            change_status: function(id,status,index){
                // console.log(id,status,index);
                let confirms = confirm('confirm!!');
                if(confirms){
                    axios.post('/orders/change-status',{id,status,index})
                    .then(res=>{
                        // console.log(res.data);
                        if(res.data.status){
                            this.orders.data[res.data.index].status = res.data.status;
                            toaster('success',this.get_order_status(res.data.status));

                            let that = this;
                            setTimeout(() => {
                                that.get_change_status_id();
                            }, 500);
                        }else{
                            toaster('error','something going wrong! try again.')
                        }
                    })
                }

            },
            get_change_status_id: function(){
                let that = this;
                $('.status-btn').off().on('click',function(){
                    let id = $(this).data('id');
                    let status = $(this).data('change_to');
                    let index = $(this).data('index');
                    that.change_status(id,status,index);
                });
            }
        },
    })

}
