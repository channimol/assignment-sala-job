const Auth = {
    state: {
        user: null,
        departments: [],
        jobList: []
    },
    mutations: {
        UPDATE_USER_PROFILE(state, payload) {
            state.user = payload
        },
        UPDATE_DEPARTMENTS(state, payload) {
            state.departments = payload.data
        },
        UPDATE_JOB_LIST(state, payload) {
            state.jobList = payload.data.data
        }
    },
    actions: {},
    getters: {
        GET_USER_PROFILE: state => {
            return state.user
        },
        GET_DEPARTMENT: state => {
            return state.departments
        },
        GET_JOB_LIST: state => {
            return state.jobList
        }
    }
}

export default Auth