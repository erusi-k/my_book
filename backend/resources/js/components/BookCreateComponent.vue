<template>
    <div class="body">
        <div class="input">
            <div class="input-content">
                <div v-for="error in errors" :key="error.id">
                    <div class="error"><p>{{error}}</p></div>
                </div>
                <div class="input-content_header">
                    <h2 class="input-content_header-title">新規作成</h2>
                    <button class="search-btn" @click="openModal">本を検索する</button> 
                </div>
                <validation-observer tag="form" ref="obs" v-slot="ObserverProps" v-on:submit.prevent="submit">  
                    <div class="input-content_body">
                        <validation-provider v-slot="ProviderProps" rules="required|max:50">
                            <p>タイトル</p>
                            <input type="text" v-model="item.title" name="タイトル">
                            <div class="error">{{ProviderProps.errors[0]}}</div>
                        </validation-provider>
                    </div>
                    <div class="input-content_body">
                        <validation-provider v-slot="ProviderProps" rules="required|max:30">
                            <p>著者</p>
                            <input type="text"  v-model="item.author" name="著者">
                            <div class="error">{{ProviderProps.errors[0]}}</div>
                        </validation-provider>
                    </div>
                    <div class="input-content_body">
                        <p class="input_rating-title">評価</p>
                        <star-rating v-model="rating" v-bind:increment="0.5"></star-rating>
                    </div>
                    <div class="input-content_body">
                        <validation-provider v-slot="ProviderProps" rules="required|max:500">
                            <p>感想</p>
                            <textarea v-model="item.report" name="感想"></textarea>
                            <div class="error">{{ProviderProps.errors[0]}}</div>
                        </validation-provider>
                    </div>
                    <button class="input-btn" type="submit" :disabled="ObserverProps.invalid">登録</button>
                </validation-observer>
            </div>
        </div>
        
        <div id="overlay" v-show="showContent" @click.self="closeModal">
            <div id="book">
                <div class="book-search">
                    <div class="book-search_main">
                        <input type="text" class="book-search_main-input" placeholder="キーワード入力してください。" v-model="query">
                        <button class="book-search_main-btn" @click="getBook(query)">検索</button>
                    </div>
                    <img class="close" @click="closeModal" src="/images/close.png">
                </div>
                <p v-if="bookEmpty">検索結果がありません</p>
                <div class="book-body">
                    <div class="book-body_content" v-for="searchData in searchDatas" :key="searchData.id">
                        <div class="book-body_content-img">
                            <img v-bind:src="searchData.volumeInfo.imageLinks&&searchData.volumeInfo.imageLinks.smallThumbnail" >
                        </div>
                        <div class="book-body_content-main">
                            <p>{{searchData.volumeInfo.title}}</p>
                            <p>{{searchData.volumeInfo.authors}}</p>
                            <button class="select-btn" @click="dataSet(searchData)">選択する</button>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['user'],
        data(){
            return {
                rating:0,
                item:{
                    user_id:this.user.id,
                    title:'',
                    author:'',
                    imge:'/images/noimage.jpg',
                },  
                searchDatas:'',
                showContent:false,
                query:'',
                bookEmpty:false,
                errors:{},
        
            }
        },
        methods: {
        // データーベース登録処理
            submit(){
                this.item.rating = this.rating;
                axios.post("http://localhost:8080/api/book",this.item)
                    .then((res)=>{
                        this.test = res;
                        this.$swal('登録が完了しました!',{
                            icon: "success",
                        });
                        console.log(this.item);
                        this.$router.push({name: 'book.home'});
                    })
                    .catch((error) =>{
                        this.errors = error.response.data.errors;
                        console.log(this.errors);
                        console.log(error);
                        this.$swal('登録に失敗しました。もう一度お試しください',{
                            icon: "error",
                        })
                    })
            },

        // 本情報検索処理
            getBook(query){
                axios.get(`https://www.googleapis.com/books/v1/volumes?q=serch+${query}&maxResults=15`)
                .then((res) => {
                    if(res.data.items != null){
                        this.searchDatas = res.data.items;
                        this.bookEmpty = false;
                    }else{
                        this.searchDatas = '';
                        this.bookEmpty = true;
                    }
                    
                    console.log(this.searchDatas);
                })
                .catch((error) => {
                    console.log(error);
                    alert('失敗です')
                })
            },
            openModal(){
                this.showContent = true;
                console.log('動いている');
            },
            closeModal(){
                this.showContent = false;
            },

        // 本検索結果form反映処理
            dataSet(data){
                this.item.title = data.volumeInfo.title;
                this.item.author = data.volumeInfo.authors[0];
                this.item.imge = data.volumeInfo.imageLinks.smallThumbnail;
                return this.closeModal();
                
            }
        },
    }
</script>

<style>

    .body {
        font-family: 'Hannotate SC','Hiragino Kaku Gothic ProN','ヒラギノ角ゴ ProN W3','メイリオ', Meiryo,sans-serif;
    }   

    input,textarea {
        width: 100%;
    }

    textarea {
        height: 200px;
    }

    .error {
        color: #666666;
    }
    
/* モーダルcss     */
    #overlay{
        z-index:1;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-color:rgba(0,0,0,0.5);
        display:flex;
        align-items:center;
        justify-content:center;
        
    }

    #book{
        z-index:2;
        width:50%;
        height:100vh;
        padding:1em;
        background:#FFF6e6;
        overflow: auto;
        overflow: scroll;
    }


/* フォーム */
    .create {
        font-weight: bold;
        font-size: 2rem;
    }

    .input {
        margin: 3rem auto 0;
        width: 70%;
        background :#FFF6e6;
        box-shadow: 0 2px 3px rgba(0,0,0,.22);
        padding: 2.2rem 0.8rem 2.2rem 0.8rem;
    }

    .input:after {
        position: absolute;
        content: '';
        top: 185px;
        width: 30%;
        height: 35px;
        opacity: 0.3;
        margin: -35px auto 10px 35%;
        background: #db7093;
        transform: rotate(-2deg);
        left: 10px;
        right: 10px;
    }

    .input-content {
        width: 50%;
        margin: auto;
    }

    .input-content_header {
        display: flex;
        justify-content: space-between;
    }
    
    .input-content_header-title {
        font-size: 2rem;
        font-weight: bold;
        border-bottom: 2px solid #fff;
    }

    .input-content_body {
        margin-top : 1rem;
    }

/* 本検索ボタン */
    .search-btn {
        color: #fff;
        width: 40%;
        padding: 1rem;
        background-color: #eb6100;
        border-radius: 10px;
    }

    .search-btn:hover {
        background: #f56500;
    }

/* 送信ボタン */
    .input-btn{
        padding: 0.5rem 1rem;
        background-color: #FFC7AF;
        border-radius: 10px;
    }

    :disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .close {
        width: 30px;
        height: 30px; 
    }

/* 本選択ボタン */
    .select-btn {
        color: #fff;
        margin-top: 2rem;
        padding: 0.5rem;
        background-color: #eb6100;
        border-radius: 10px;
    }

    .select-btn:hover {
        background: #f56500;
    }

/* 本検索結果 */
    .book-search {
        display: flex;
        justify-content: space-between;
    }

    .book-search_main {
        display: flex;
        margin-top: 2rem;
        width: 80%;
    }

    .book-search_main-input {
        margin: auto;
        width: 80%;
        border-radius: 30px;
    }

    .book-search_main-btn {
        padding: 0.5rem 1rem;
        background-color: #FFC7AF;
        border-radius: 10px;
    }

    .book-body {
        display: flex;
        flex-wrap: wrap;
    }

    .book-body div {
        width: 44.2%;
    }

    .book-body_content {
        display: flex;
        margin: 2rem 1rem;
    }

    .book-body_content-img img {
        width: 80%;
        height: 200px;
    }


    @media screen and (max-width:1024px) {
        /* body {
            margin-top: 5rem;
        } */
        
        .input {
            width:90%;
            padding: 1rem 0.5rem;
            margin-top: 8rem;
        }

        .input:after {
            position: absolute;
            content: '';
            top: 20px;
            width: 50%;
            height: 35px;
            opacity: 0.3;
            margin: -35px auto 10px;
            background: #db7093;
            transform: rotate(-2deg);
        }

        .input-content_header-title {
            border: none;
            width: 80%;
        }

        .input-content {
            width: 100%;
        }

        .input-content_header {
            margin-top: 1rem;
            font-size: 1rem;
        }

        /* モーダル */
        #book {
            width:100%;
            margin-top: 7rem;
        }

        .book-search_main {
            width: 100%;
        }

        .book-search_main-btn {
            margin-left: 0.3rem;
        }

        .book-body {
            display: block;
        }

        .book-body div {
            width: 80%;
            margin: 1rem auto;
        }
    }

    
</style>