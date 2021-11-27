import axios from "axios";

// state list
const state = {
    recent_views: [],
};

// get state
const getters = {
    get_recent_views: (state) => state.recent_views,
};

// actions
const actions = {
    // fetch_basic_information: function (state) {
    //     axios.get("/api/").then((res) => {
    //         // console.log(res.data);
    //         this.commit("set_basic_information", res.data);
    //     });
    // },
};

// mutators
const mutations = {
    set_recent_views: function (state, recent_views) {
        if(state.recent_views.length){
            state.recent_views.splice(10,state.recent_views.length);
        }
        state.recent_views = state.recent_views.filter((item)=>item.id != recent_views.id);
        state.recent_views.unshift(recent_views);
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};


