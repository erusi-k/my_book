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
                                <!-- <p class="tag">{{timeStamp(myData.created_at)}}</p> -->
                                <router-link :to="`/book/show/${myData.id}`" >詳細へ</router-link>
                            </div>
                        </div>
                    </div> 
            </transition>
        </div>

        <p @click="handleScroll()">テスト</p>
        <p >どむテスト</p>
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
    }
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
</style>