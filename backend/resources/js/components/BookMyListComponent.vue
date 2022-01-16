<template>
    <div class="body">
        <div class="my_data">
            <p>自分の投稿</p>
            <div v-for="myData in myDatas" :key="myData.id">
                <div class="my_data-content">
                    <div class="my_data-content_image">
                        <img v-bind:src="myData.imge">
                    </div>
                    <div class="my_data-content_body">
                        <div class="my_data-content_body-title">
                            <p class="tag">タイトル</p>
                            <p class="content-main title">{{myData.title}}</p>
                        </div>
                        <div class="my_data-content_body-author">
                            <p class="tag">著者</p>
                            <p class="content-main author" >{{myData.author}}</p>
                        </div>
                        <div class="my_data-content_body-rating">
                            <p class="tag">評価</p>
                            <p class="content-main rating">{{myData.rating}}</p>
                        </div>
                        <div class="my_data-content_body-footer">
                            <!-- <p class="tag">{{timeStamp(myData.created_at)}}</p> -->
                            <router-link :to="`/book/show/${myData.id}`" >詳細へ</router-link>
                        </div>
                    </div>
                </div>
            </div>
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