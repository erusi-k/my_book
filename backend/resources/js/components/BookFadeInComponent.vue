<template>
    <div>
        <div v-for="myData in myDatas" :key="myData.id">
            <transition >
                    <div ref="scroll" v-show="visible"  class="my_data-content">
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
                                <p class="tag">{{timeStamp(myData.created_at)}}</p>
                                <router-link class="btn" :to="`/book/show/${myData.id}`" >詳細へ</router-link>
                            </div>
                        </div>
                    </div> 
            </transition>
        </div>
    </div>
</template>

<script>
export default({
    props:['myDatas'],
    data(){
        return{
            visible: true,
        }
    },
    // created(){
    //     window.addEventListener("scroll",this.handleScroll);
        
    // },

    mounted(){
        this.handleScroll();
    },

    methods: {
        handleScroll(){
            console.log(window.scrollY);
            const scroll = this.$refs.scroll;
            console.log(scroll);
            const rect = scroll.getBoundingClientRect();
            const top = rect.top + window.pageYOffset;
            console.log(window.innerHeight);
            console.log(rect);
            if(!this.visible){
                this.visible = window.innerHeight > top;
            }else {
                this.visible = false;
            }
        }
    },

    computed:{
            timeStamp:function(){
                return function(value) {
                    return value.substring(0,10);
                }
            }
        },
})
</script>

<style>

    .p {
        font-size:300px;
    }

    .v-leave-active,
    .v-enter-active {
        transition: opacity 1s;
    }

    .v-enter {
        opacity: 0;
    }

    .v-enter-to {
        opacity: 1;
    }

    .v-leave {
        opacity: 1;
    }

    .v-leave-to {
        opacity: 0;
    }

    .my_data-content,.my_data-content_body-title, 
.my_data-content_body-author,.my_data-content_body-rating {
    display: flex;
    margin-top: 0.6rem;
    border-bottom: 1px dashed #fff;
}

.my_data-content_body-footer {
    display: flex;
    margin-top: 0.6rem;
    justify-content: space-between;
}

.my_data {
    width: 100%;
}

.my_data-content {
    width: 900px;
    height: 180px;
    background: #FFDBC9;
    padding: 0.2rem 0.5rem;
    margin: auto;
    margin-top: 2rem;
    box-shadow: 0px 0px 0px 10px #FFDBC9;
    border: 2px dashed #fff;
}

.my_data-content_body {
    margin: 1rem 0 0 6rem;
    width: 70%;
}

.my_data-content_image {
    width: 15%;
}

.my_data-content_image img {
    width: 100%;
    height: 100%;
}

.tag {
    font-size: 1rem;
    
}

.content-main {
    font-size: 2.3vmin;
    margin-left: 5rem;
}

.author, .rating {
    margin-left: 7rem;
}

.btn {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 30%;
    height: 35px;
    background-color: #FF5F17;
    box-sizing: border-box;
    color: #fff;
    font-size: 16px;
    letter-spacing: 0.1em;
    line-height: 2.0;
    text-decoration: none;
    transition-duration: 0.3s;
    position: relative;
}

.btn:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 15px 20px 0 0;
    border-color: #ffffff transparent transparent transparent;
}

.btn:after {
    content: "";
    position: absolute;
    top: -6px;
    left: 5px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 0 20px 15px;
    border-color: transparent transparent #efefef transparent;
    box-shadow: 1px 1px 1px 0px rgba(0, 0, 0, 0.15);
    transform: rotate(16deg);
}

.btn:hover {
    background-color: #e6de6b;
}

.btn span {
    position: relative;
    padding-left: 16px;
    letter-spacing: 0.05em;
}

.btn span:before {
    content: '';
    width: 6px;
    height: 6px;
    border: 0;
    border-top: solid 2px #fff;
    border-right: solid 2px #fff;
    transform: rotate(45deg);
    position: absolute;
    top: 50%;
    left: 0;
    margin-top: -4px;
}
</style>