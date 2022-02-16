<template>
<div class="body">
    <div v-show="isLoading" class="loading">   
        <vue-loaders v-show='isLoading'  name ="ball-spin-fade-loader" color="#FF8856" scale="3"></vue-loaders>
    </div>
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
            <router-link class="show-content_footer-edit" :to="`/book/edit/${item.id}`" v-if="checkId(item.user_id)">編集する</router-link>
            <p class="show-content_footer-delete"  @click="dataDelete(item.id)" v-if="checkId(item.user_id)">削除する</p>
        </div>
        <div :class="[checkId(item.user_id) ? 'show-content_mycard' : 'show-content_othercard']">
            <div class="show-content_card-image">
            <img v-bind:src="item.imge">
            </div>
            <div class="show-content_card-body">
                <div class="show-content_card-body_title">
                    <p class="tag">タイ<br>トル</p>
                    <p class="content-main title" >{{item.title}}</p>
                </div>
                <div class="show-content_card-body_author">
                    <p class="tag">著者</p>
                    <p class="content-main author">{{item.author}}</p>
                </div>
                <div class="show-content_card-body_rating" >
                    <p class="tag">評価</p>
                    <star-rating class="content-main rating"  v-model="item.rating" v-bind:increment="0.5" :read-only="true" :star-size=29></star-rating>
                </div>
            </div>
        </div>
    </div>
    <a class="back_btn" @click="$router.back()">戻る</a>
</div>    
</template>

<script>
export default ({
    props:['bookId','user'],
    data(){
        return {
            items:'',
            isLoading: true,
            resp: false,
        }
    },
    methods:{

    //詳細データ取得    
        getData(){
            const baseUrl = process.env.MIX_API_URL;
            const id = this.bookId
            
            axios.get(`${baseUrl}/`+id)
            .then((res) => {
                this.items = res.data;
                this.isLoading = false;
                console.log(this.res);
            })
            .catch((error) => {
                console.log(error);
            })
        },

    //ログインユーザー確認    
        checkId(user_id){
            if(this.user.id == user_id){
                return true;
                
            }
            return false;
            
        },

     //投稿削除処理   
        dataDelete(id){
            const baseUrl = process.env.MIX_API_URL;
            this.$swal({
                title: "確認",
                text: '本当に削除してもよろしいですか？',
                icon: "warning",
                buttons: true,
                dangerMde: true,
            })
            .then((willDelete) => {
                if(willDelete) {
                    axios.delete(`${baseUrl}/` +id)
                    .then((res) => {
                    console.log(res);
                    this.$swal('削除しました!');
                    this.$router.push({name:'book.home'});
                })
                    .catch((error) => {
                    console.log(error);
                    alert('削除失敗です');
                });
                }
            });
        },

    //画面検知    
        handleResize(){
            if(window.innerWidth <= 480){
                this.resp = true;
            }else if(window.innerWidth <= 1024) {
                this.resp = true;
            }else {
                this.resp = false;
            }
            
        }
        
    },

    created(){
        this.getData();
    }
})
</script>

<style scoped>


.body {
    font-family: 'Avenir','Arial Rounded MT Bold','Comic Sans MS','Hannotate SC','Hiragino Kaku Gothic ProN','ヒラギノ角ゴ ProN W3','Yu Gothic UI',sans-serif;
}

/* ローディングぐるぐる */
.loading {
    position:fixed;
    top:0;
    left:0;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255,1);
    z-index: 80;
    display: flex;
    align-items: center;
    justify-content: center;

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

/* 戻るボタン */

.back_btn {
    display: inline-block;
    background: #FFC7AF;
    padding: 1rem 1.5rem;
    color: #000;
    border: 1px solid #FFC7AF;
    border-radius: 15px;
    margin: 5rem 0  0 10rem;
}

.back_btn {
    cursor: pointer;
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
    height: 180px;
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
    height: 180px;
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
    justify-content: right;
}
.show-content_footer p {
    margin-left: 0.6rem;
}

.show-content_footer-edit {
    background: #fff;
    padding: 0.3rem 0.8rem;
    color: #BBBBBB;
    border: 1px solid #BBBBBB;
    border-radius: 15px;
}

.show-content_footer-delete {
    background: #555555;
    padding: 0.3rem 0.8rem;
    color: #fff;
    border: 1px solid #555555;
    border-radius: 15px;
}

.show-content_footer-delete:hover {
    cursor: pointer;
}

.show-content_card-image {
    width: 20%;
}

.show-content_card-image img {
    width: 100%;
    height: 100%;
}

.show-content_card-body {
    margin: 1rem 0 0 3rem;
    width: 75%;
}


.show-content_card-body_title,
.show-content_card-body_author,
.show-content_card-body_rating {
    display: flex;
    margin-top: 0.6rem;
    border-bottom: 1px dashed #fff;
}

.content-main {
    width: 80%;
    margin-left: 5rem;
}

.title {
    padding-top: 0.5rem;
}

.title,.author,.rating {
    font-size: 1.2rem;
    margin-left :4rem;
}

.tag  {
    font-size: 1.3rem;
    width: 20%;
}


@media screen and (max-width: 1024px) {
    body {
        margin-top: 5rem;
    }
    

    .title,.author,.rating {
        margin-left: 0;
        font-size: 1rem;
    }  
    
    .tag {
        font-size: 1rem;
    }
}

@media screen and (max-width:800px) {
    body {
        margin-top: 5rem;
    }


    .show-content {
        width: 90%;
    }

    .show-content:after {
        top: 120px;
    } 
    
    .show-content_mycard, .show-content_othercard {
        height: 150px;
    }

    .show-content_card-image {
        width: 25%;
    }

    .show-content_card-image img {
        width: 100%;
    }

    .show-content_card-body {
        margin: 0;
        margin-left: 1rem;
        width: 70%;
    }

    .content-main {
        margin: 0;
        margin-left: 0.7rem;
    }

    .title {
        margin-top: 0.6rem;
    }

    .title,.author {
        font-size: 0.8rem;
    }

}
</style>