<template>
<div class="body">
    <div class="show-content" v-for="item in items" :key="item.id">
        <div class="show-content-header">
            <p class="show-content-header_title">感想</p>
            <div :class="[ checkId(item.user_id) ? 'show-content-header_myname': 'show-content-header_othername']">
                <p class="show-content-header_name-main">ユーザー名: {{item.user_name}}</p>
            </div>
        </div>
        <div class="show-content_note">
        <div class="show-content_sen">
        <p>{{item.report}}</p>
        </div>
        </div>
        <div class="show-content_footer" >
                    <router-link :to="`/book/edit/${item.id}`" v-if="checkId(item.user_id)">編集する</router-link>
                    <p @click="dataDelete(item.id)" v-if="checkId(item.user_id)">削除する</p>
                </div>
        <div :class="[checkId(item.user_id) ? 'show-content_mycard' : 'show-content_othercard']">
            <div class="show-content_card-image">
            <img v-bind:src="item.imge">
            </div>
            <div class="show-content_card-body">
                <div class="show-content_card-body_title">
                    <p class="tag">タイトル</p>
                    <p class="content-main">{{item.title}}</p>
                </div>
                <div class="show-content_card-body_author">
                    <p class="tag">著者</p>
                    <p class="content-main author">{{item.author}}</p>
                </div>
                <div class="show-content_card-body_rating" >
                    <p class="tag">評価</p>
                    <star-rating class="content-main rating"  v-model="item.rating" v-bind:increment="0.5" :read-only="true" :star-size=30></star-rating>
                </div>
                
            </div>
        </div>
        
    </div>
</div>    
</template>

<script>
export default ({
    props:['bookId','user'],
    data(){
        return {
            items:'',
        }
    },
    methods:{
        getData() {
            const id = this.bookId
            axios.get("http://localhost:8080/api/book/"+id)
            .then((res) => {
                
                this.items = res.data;
                console.log(this.items);
            })
            .catch((error) => {
                console.log(error);
            })
        },
        checkId(user_id){
            if(this.user.id == user_id){
                console.log('真です')
                return true;
                
            }
            console.log('偽です')
            return false;
            
        },
        dataDelete(id){
            const flag = confirm('本当に削除してもよろしいですか？？')

            if(flag == true) {
                axios.delete('http://localhost:8080/api/book/' +id)
                .then((res) => {
                    console.log(res);
                    alert('削除しました!');
                    this.$router.push({name:'book.home'});
                })
                .catch((error) => {
                    console.log(error);
                    alert('削除失敗です');
                })
            }   
        }
        
    },

    computed:{

    },

    mounted(){
        
    },


    created(){
        this.getData();
        
        
    }
})
</script>

<style scoped>


.body {
    font-family: 'Hannotate SC','Hiragino Kaku Gothic ProN','ヒラギノ角ゴ ProN W3','メイリオ', Meiryo,sans-serif;
}

.show-content {
        margin: 3rem auto 0;
        width: 70%;
        background :#FFF6e6;
        box-shadow: 0 2px 3px rgba(0,0,0,.22);
        padding: 2.2rem 0.8rem 0 0.8rem;
}

.show-content:after {
        position: absolute;
        content: '';
        top: 150px;
        width: 30%;
        height: 35px;
        opacity: 0.3;
        margin: auto ;
        background: rgb(177, 255, 133);
        transform: rotate(-2deg);
        left: 10px;
        right: 10px;
}

/* 自分の投稿の時のスタイル */
.show-content-header_myname {
    position: relative;
    padding: 0.5rem 0.7rem;
    margin: 2rem 0;
    background: #FFDBC9;
    color: #FF9872;
    font-weight: bold;
    display: inline-block;
}

.show-content-header_myname:after {
    position: absolute;
    content: '';
    top: 100%;
    left: 30px;
    border: 15px solid transparent;
    border-top: 15px solid #FFDBC9;
    width: 0;
    height: 0;
}

.show-content_mycard {
    display: flex;
    width: 100%;
    height: 150px;
    background: #FFDBC9;
    padding: 0.2rem 0.5rem;
    margin: auto;
    margin-top: 2rem;
    box-shadow: 0px 0px 0px 10px #FFDBC9;
    border: 2px dashed #fff;
}
/* 終わり */


/* 他の人の投稿の時のスタイル */
.show-content-header_othername {
    position: relative;
    padding: 0.5rem 0.7rem;
    margin: 2rem 0;
    background: #e6f4ff;
    color: #5c98d4;
    font-weight: bold;
    display: inline-block;
}

.show-content-header_othername:after {
    position: absolute;
    content: '';
    top: 100%;
    left: 30px;
    border: 15px solid transparent;
    border-top: 15px solid #e6f4ff;
    width: 0;
    height: 0;
}

.show-content_othercard {
    display: flex;
    width: 100%;
    height: 150px;
    background: #d6edff;
    padding: 0.2rem 0.5rem;
    margin: auto;
    margin-top: 2rem;
    box-shadow: 0px 0px 0px 10px #d6edff;
    border: 2px dashed #fff;
}
/* 終わり */

.show-content-header {
    display: flex;
    justify-content: space-between;
}


.show-content-header_title {
    font-weight: bold;
    font-size: 3rem;
    letter-spacing: 0.5rem;
}



.show-content_note {
    background-color: #fff6e6;
    color: #000;
    margin: 0.5rem 0;
    font-weight: bold;
    border: solid 1px #ee8992;
    padding: 0.3rem 1rem 2rem 1rem;
    box-shadow:2px 2px 0 rgba(0,0,0,.1);
    border-radius: 7px;
}
.show-content_sen {
    background-color: #fff6e6;
    background-image:
    linear-gradient(90deg, rgba(255, 246, 230, 0) 0%, rgba(255, 246, 230, 0) 50%, #fff6e6 0%, #fff6e6 100%), linear-gradient(180deg, rgba(237, 119, 128, 0) 0%, rgba(237, 119, 128, 0) 95%, #ed7780 100%);
    background-size: 8px 100%,100% 2em;
    line-height: 2rem;
    padding: 2rem 1rem 0.2rem 1rem;
}

.show-content_footer {
    display: flex;
    text-align: right;
}

.show-content_card-image img {
    height: 100%;
}

.show-content_card-body {
    margin: 1rem 0 0 3rem;
    width: 70%;
}

.show-content_card-body_title,
.show-content_card-body_author,
.show-content_card-body_rating {
    display: flex;
    margin-top: 0.6rem;
    border-bottom: 1px dashed #fff;
}

.content-main {
    margin-left: 5rem;
}

.author,.rating {
    margin-left :7rem;
}

</style>