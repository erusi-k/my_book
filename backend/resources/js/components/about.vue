<template>
    <div>
        <p>{{user.name}}</p>
        <p >{{user.email}}</p>
        <p type="button" @click="logout" >ログアウト</p>
    </div>
</template>

<script>
export default {
    data(){
        return{
            user: '',
        }
    },

    mounted(){
        axios.get("/api/user").then(response => {
            this.user = response.data;
        });
        console.log(this.user);
    },

    created(){
        this.test();
    },

    methods: {
        logout(){
            axios.get("api/logout")
            .then(response => {
                console.log(response);
                this.$router.push({name: 'login'});
            })
            .catch(error => {
                console.log(error);
            })
        },

        test(){
            console.log('テスト');
            console.log(this.user);
        }
    }
}
</script>