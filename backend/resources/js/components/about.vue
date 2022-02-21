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

    created(){
        this.getUser();
    },

    methods: {
        logout(){
            axios.post("/api/logout")
            .then(response => {
                console.log(response);
                this.$router.push({name: 'book.login'});
            })
            .catch(error => {
                console.log(error);
            })
        },

        getUser(){
            axios.get("/api/user").then(response => {
            if(!response.data){
                this.$router.push({name: 'book.login'});
            }
            console.log('接続はできてます');
            this.user = response.data;
        })
        .catch((error) => {
            console.log(error);
            this.$router.push({name: 'book.login'});
        });
        console.log(this.user);
        }
    }
}
</script>