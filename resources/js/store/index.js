import { createStore } from "vuex";

const store = createStore({
    state:{
        //variables
        token: localStorage.getItem('token') || 0,
        userId: null,
    },

    mutations:{
        //update variable value
        UPDATE_TOKEN:function(state, payload){
            state.token = payload
        },
        SET_User_ID: function (state, payload) {
            state.userId = payload;
          },

    },

    actions:{
        // action to be performed
        setToken: function(context,payload){
            localStorage.setItem('token',payload);
            context.commit('UPDATE_TOKEN', payload)
        },
        removeToken: function(context){
            localStorage.removeItem('token')
            context.commit('UPDATE_TOKEN',0)
        },
        setUserId: function (context, payload) {
            context.commit('SET_User_ID', payload);
          },

    },

    getters:{
        // get state variable value
        getToken: function(state){
            return state.token
        },
        getUserId: function (state) {
            return state.userId;
          },
    }
})

export default store;
