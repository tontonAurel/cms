<template>
    <div class="container">
        <b-jumbotron :header="post.title" :lead="post.description" class="jumbotron m-2" v-for="post in posts"
                     :key="post.id">
            <hr class="my-4">
            <b-card-group columns>
                <b-card v-for="(media, idx) in post.medias" :title="media.title" :key="media.id"
                        :no-body="!media.title && !media.description"
                        :img-src="media.thumb"
                        img-fluid
                        img-alt="image"
                        @click.prevent="gallery(post.medias, idx)"
                        img-top>
                    <p class="card-text" v-html="media.description"></p>
                </b-card>
            </b-card-group>
        </b-jumbotron>
        <b-modal id="modal1" ref="mediaModalRef" hide-header hide-footer size="lg" centered v-model="show">
            <v-touch @swipeleft="next" @swiperight="prev">
                <b-carousel id="carousel1"
                            style="text-shadow: 1px 1px 2px #333;"
                            controls
                            background="#ababab"
                            img-width="1024"
                            img-height="480"
                            v-model="slide"
                            :interval="0"
                >
                    <b-carousel-slide v-for="media in galleryMedias" :caption="media.title" :key="media.id"
                                      :text="media.description"
                                      :img-src="media.big"
                    ></b-carousel-slide>
                </b-carousel>
            </v-touch>
        </b-modal>
        <div class="loader justify-content-center mt-5 mb-5 w-100" v-show="nextUrl" :class="{'d-flex': nextUrl}"><i
                class="fas fa-5x fa-spinner fa-spin"></i></div>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        data: function () {
            return {
                nextUrl: null,
                loading: false,
                show: false,
                galleryMedias: [],
                slide: 0,
                posts: []
            }
        },
        mounted() {
            this.nextUrl = this.data.next_page_url
            this.posts = this.data.data
            window.addEventListener('scroll', this.listener);
            this.listener()
        },
        methods: {
            listener(event) {
                var element = document.documentElement;
                if (element.scrollHeight - element.scrollTop === element.clientHeight) {
                    if (!this.loading && this.nextUrl) {
                        this.loading = true
                        window.axios.get(this.nextUrl).then((response) => {
                            this.posts = this.posts.concat(response.data.data);
                            this.nextUrl = response.data.next_page_url
                            this.loading = false;
                        })
                    }
                }
                if (!this.nextUrl) {
                    this.loading = false
                    window.removeEventListener('scroll', this.listener);
                }
            },
            gallery(medias, idx) {
                this.galleryMedias = medias
                this.$nextTick(() => {
                    this.slide = idx
                    this.show = true
                })
            },
            prev() {
                this.slide = Math.max(this.slide - 1, 0)
            },
            next() {
                this.slide = Math.min(this.slide + 1, this.galleryMedias.length - 1)
            }
        }
    }
</script>
