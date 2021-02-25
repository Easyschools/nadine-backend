export default {
    namespaced: true,
    state: {
        token: null,
        user: null
    },
    getters: {
        authenticated(state) {
            return state.token != null
        },
        user(state) {
            return state.user
        }
    },
    mutations: {
        SET_TOKEN(state, token) {
            state.token = token
        },
        SET_USER(state, user) {
            state.user = user
        }
    },
    actions: {
        async login({dispatch}, credentials) {
            let response = await axios.post('/admin/login', credentials);
            return dispatch('attempt', response.data.data.token);
        },
        async attempt({commit, state}, token) {
            if (token) {
                commit('SET_TOKEN', token);
            }
            if (!state.token) {
                return
            }
            // commit('SET_USER', {email: data.email, name: data.name});
        },
        logout({commit}) {
            return axios.post('/admin/logout')
                .then(() => {
                    commit('SET_TOKEN', null);
                });

        }
    }
}
