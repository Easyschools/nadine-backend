export default {
    namespaced: true,
    state: {
        token: null,
        user: null,
        flag: 0
    },
    getters: {
        authenticated(state) {
            return state.token != null;
        },
        user(state) {
            return state.user;
        }
    },
    mutations: {
        SET_TOKEN(state, token) {
            state.token = token;
        },
        SET_USER(state, user) {
            state.user = user;
        },
        SET_Flag(state, flag) {
            state.flag = flag;
        }
    },
    actions: {
        collapseNavBar({ commit, state }) {
            let nav = document.getElementById("lorem");
            nav.classList.add("mob-open");
            let iconCollapse = document.getElementById("mobile-collapse ");
            iconCollapse.style.opacity = "0";
            console.log("open");
        },
        closeSideBar({ commit, state }) {
            let nav = document.getElementById("lorem");
            nav.classList.remove("mob-open");
            console.log("close");
            let iconCollapse = document.getElementById("mobile-collapse ");
            iconCollapse.style.opacity = "1";
            // iconCollapse.classList.add('d-inline-block');

            // if (nav.classList.contains("mob-open") === false) {
            //     nav.classList.add("mob-open");
            // } else {
            //     nav.classList.remove("mob-open");
            // }
        },
        async login({ dispatch }, credentials) {
            let response = await axios.post("/admin/login", credentials);
            return dispatch("attempt", response.data.data.token);
        },
        async attempt({ commit, state }, token) {
            if (token) {
                commit("SET_TOKEN", token);
            }
            if (!state.token) {
                return;
            }
            // commit('SET_USER', {email: data.email, name: data.name});
        },
        logout({ commit }) {
            return axios.post("/admin/logout").then(() => {
                commit("SET_TOKEN", null);
            });
        }
    }
};
