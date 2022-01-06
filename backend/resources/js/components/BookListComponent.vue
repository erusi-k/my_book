<template>
    <div>
        <div>
            <p>みんなの投稿 </p>
            <div v-for="other in others" :key="other.id">  
                    {{other.title}}
                    {{other.author}}
                    {{other.rating}}
                    <img v-bind:src="other.imge" alt="">
                    <router-link :to="`/book/show/${other.id}`">詳細へ</router-link>
            </div>
        </div>
        <div>
            <p>自分の投稿</p>
            <div v-for="myData in myDatas" :key="myData.id">
                {{myData.title}}
                {{myData.author}}
                {{myData.rating}}
                <img v-bind:src="myData.imge">
                <router-link :to="`/book/show/${myData.id}`" >詳細へ</router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['user'],
    
    data(){
        return{
            others:'',
            myDatas:'',
        }
        
    },
    methods:{
        async getOtherData(){
            await axios.get("http://localhost:8080/api/book/other",{params:{user_id:this.user.id}})
            .then((res)=>{
                this.others = res.data.data
                console.log('データ取得は動いています');
                console.log(this.others);
            })
            .catch((error) => {
                console.log(error);
                alert('失敗です');
            })
        },

        async getMyData(){
            await axios.get("http://localhost:8080/api/book/mydata",{params:{user_id:this.user.id}})
            .then((res) => {
                this.myDatas = res.data.data;
                console.log(this.myDatas);
            })
            .catch((error) => {
                console.log(error);
            })
        }
    },
    created() {
        this.getOtherData();
        this.getMyData();
    }
}
</script>