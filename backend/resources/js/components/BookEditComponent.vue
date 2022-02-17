<template>
    <div class="body">
        <div v-show="isLoading" class="loading">   
            <vue-loaders v-show='isLoading' name ="ball-spin-fade-loader" color="#FF8856" scale="3"></vue-loaders>
        </div>
        <div class="input">
            <div class="input-content">
                <div v-for="error in errors" :key="error.id">
                    <div class="error"><p>{{error}}</p></div>
                </div>
                <div class="input-content_header">
                    <h2 class="input-content_header-title">編集</h2>
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
                    <button class="input-btn" type="submit" :disabled="ObserverProps.invalid">更新</button>
                </validation-observer>
            </div>
        </div>
        <a class="back_btn" @click="$router.back()">戻る</a>
    </div>    
</template>

<script>
export default ({
    props:['user','bookId'],
    data(){
        return{
            item:'',
            rating:'',
            errors: {},
            isLoading: true,
        }
    },
    methods:{

    // ログインユーザーチェック処理    
        checkId(id){
            if(this.user_id !== id) {
                this.$router.push({name: 'book.home'});
            }
        },

    // 編集データ取得    
        getData() {
            const baseUrl = process.env.MIX_API_URL;
            const id = this.bookId;
            axios.get(`${baseUrl}/`+id)
            .then((res) => {
                console.log(res.data.data);
                this.item = res.data.data;
                this.rating = res.data.data.rating;
                this.isLoading =false;
            })
            .catch((error) => {
                console.log(error);
                alert('データ取得に失敗しました')
            })
        },

    // 編集内容データベース登録処理
        submit(){
            const baseUrl = process.env.MIX_API_URL;
            this.$swal({
                title: "確認",
                text: 'こちらの内容で更新しますか？',
                icon: "info",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) =>{
                if(willDelete){
                    this.item.rating = this.rating;
                    axios.put(`${baseUrl}/`+this.bookId,this.item)
                    .then((res) => {
                    console.log(res);
                    this.$swal('更新に成功しました',{
                        icon: "success"
                    });
                    this.$router.push({name: 'book.home'});
                }).catch((error) => {
                    console.log(error);
                    this.$swal('更新に失敗しました',{
                        icon: "error"
                    });
                })
                }
            })
        }
    },
    mounted(){
        this.checkId();
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

/* 戻るボタン */

.back_btn {
    display: inline-block;
    background: #FFC7AF;
    padding: 1rem 1.5rem;
    color: #000;
    border: 1px solid #FFC7AF;
    border-radius: 15px;
    margin: 2rem 0  0 10rem;
}

/* form */
input,textarea {
    width: 100%;
    }

textarea {
    height: 200px;
}

.error {
    color: #666666;
}

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


.input-btn{
    display: block;
    padding: 0.5rem 1rem;
    background-color: #FF6666;
    border-radius: 10px;
    margin-left: auto;
}

:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

@media screen and (max-width: 1024px) {
    body {
        margin-top: 5rem;
    }

    .input {
        margin-top:9rem;
    }

    input:after {
        top: 18px;
    }
}




@media screen and (max-width:480px) {
    body {
        margin-top: 5rem;
    }


    .input {
        width:90%;
        padding: 1rem 0.5rem;
        margin-top:9rem;
    }

    .input:after {
        top: 18px;
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
}



</style>