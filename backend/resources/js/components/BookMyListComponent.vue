<template>
    <div class="body">
        <div class="my_data">
            <p>自分の投稿</p>
            <bookFadeIn-component v-bind:myDatas="myDatas"></bookFadeIn-component>
        </div>
    </div>
</template>

<script>
export default ({
    props:['user'],
    data(){
        return{
            myDatas: '',
        }
    },
    methods:{
        async getMyData(){
            await axios.get("http://localhost:8080/api/book/mydata",{params:{user_id:this.user.id}})
            .then((res) => {
                this.myDatas = res.data.data;
                console.log(this.myDatas);
            })
            .catch((error) => {
                console.log(error);
            })
        },
    },
    created(){
        this.getMyData();
    }
})
</script>

<style scoped>

</style>