<template>
    <div class="body">
        <div v-show="isLoading" class="loading">   
            <vue-loaders v-show='isLoading'  name ="ball-spin-fade-loader" color="#FF8856" scale="3"></vue-loaders>
        </div>
        <div class="my_data">
            <p class="heading">自分の投稿</p>
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
            isLoading: true,
        }
    },
    methods:{
        async getMyData(){
            await axios.get("http://localhost:8080/api/book/mydata",{params:{user_id:this.user.id}})
            .then((res) => {
                this.myDatas = res.data.data;
                this.isLoading = false;
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

/* ローディングぐるぐる */
.loading {
    position:fixed;
    top:0;
    left:0;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255,0.7);
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;

}

.heading {
    display: inline-block;
    font-weight: bold;
    font-size: 1.5rem;
    border-bottom: 2px solid #fff;
}

.heading:first-letter {
    color: #FF5F17;
    font-size: 3rem;
}

</style>