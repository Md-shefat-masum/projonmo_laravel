import axios from 'axios';

// state list
const state = {
    check_auth: false,
    auth_info: {
        id: null,
        first_name: null,
        last_name: null,
        username: null,
        role_id: null,
        avatar: null,
        phone: null,
        address: null,
        status: null,
    },
    default_login_form_show: true,
    auth_errors:{}
}

// get state
const getters = {
    get_check_auth: state => state.check_auth,
    get_auth_info: state => state.auth_info,
    get_default_login_form_show: state => state.default_login_form_show,
    get_auth_errors: state => state.auth_errors,
}

// actions
const actions = {
    fetch_auth_info: function (state) {
        axios.get('/json/get-auth-information')
            .then((res) => {
                if (res.data.check_auth) {
                    this.commit('set_auth_info', res.data.auth_info);
                    this.commit('set_check_auth', true);
                }else{
                    this.commit('set_check_auth', false);
                }
            })
    },

    fetch_auth_login: function(state,info){
        // console.log(info);
        axios.post('/json/custom-login',info)
            .then((res)=>{
                // console.log(res.data);
                if(!res.data.auth_status){
                    this.commit('set_auth_errors',res.data.errors);
                }else{
                    this.commit('set_auth_info', res.data.auth_info);
                    this.commit('set_check_auth', true);
                    $('#logInModal').modal('hide');
                    $('.modal-backdrop').hide();
                }
            })
            .catch((err)=>{
                // console.log(err.response.data.errors);
                this.commit('set_auth_errors',err.response.data.errors);
            })
    },

    fetch_auth_register: function(state,info){
        // console.log(info);
        axios.post('/json/custom-register',info)
            .then((res)=>{
                // console.log(res.data);
                if(!res.data.auth_status){
                    this.commit('set_auth_errors',res.data.errors);
                }else{
                    this.commit('set_auth_info', res.data.auth_info);
                    this.commit('set_check_auth', true);
                    $('#logInModal').modal('hide');
                    $('.modal-backdrop').hide();
                }
            })
            .catch((err)=>{
                // console.log(err.response.data.errors);
                this.commit('set_auth_errors',err.response.data.errors);
            })
    }
}

// mutators
const mutations = {
    set_check_auth: function (state, check_auth) {
        state.check_auth = check_auth;
        state.auth_errors = {};
        state.default_login_form_show = true;
    },
    set_auth_info: function (state, auth_info) {
        state.auth_info = auth_info;
    },
    set_toggle_default_login_form_show: function (state) {
        state.default_login_form_show = !state.default_login_form_show;
    },
    set_auth_errors: function (state,auth_errors) {
        state.auth_errors = auth_errors;
    },
}

export default {
    state,
    getters,
    actions,
    mutations
}
