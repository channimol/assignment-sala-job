export default {
    methods: {
        async logout() {
            const cookies = this.$cookies.keys()
            console.log('cookies', cookies)
            await cookies.forEach(cookie => {
                this.$cookies.remove(cookie)
            })
            this.$router.push({ name: 'login' })
        },
        redirectRouteName(name) {
            if (name == "login") {
                this.logout();
                return;
            }
            this.$router.push({ name: url });
        }
    }
}