<template>
    <div v-if="isLoading">
        <loading v-model:active="isLoading"
            :can-cancel="true"
            :on-cancel="onCancel"
            :is-full-page="fullPage"/>
    </div>
    <div v-else class="container mt-4 areaResult">
        <div class="row">
            <div class="col-12">
                <div class="mb-4 marcoViewvideo">
                    <div>
                        <iframe v-bind:src="link_video" width="800" height="490" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="areaInformacionVideo">
                        <p class="tituloSingleVideo">{{ titulo_video }}</p>
                        <p class="fechaPublicacion">Publicado el {{ fecha_publicado.substring(8, 10) + "-" + fecha_publicado.substring(5, 7) + "-" + fecha_publicado.substring(0, 4) }}</p>
                        <p class="descripcionVideo">{{ descripcion }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h5 class="videosRecomendados">Videos recomendados</h5>
                <hr class="linea" /> 
                <div class="row videosEncontrados">
                    <div class="col-4 marcoVideo" v-for="miVideo in listaVideos" v-bind:key="miVideo.id.videoId">
                        <router-link exact-active-class="active" :to="{ name: 'viewvideo', params: { video_details: JSON.stringify( { idvideo: miVideo.id.videoId, titulovideo: miVideo.snippet.title, publicado: miVideo.snippet.publishTime, descripcion: miVideo.snippet.description, keywords: palabrasClaves } ) } }">
                            <div>
                                <div>
                                    <img v-bind:src="miVideo.snippet.thumbnails.medium.url" alt="" class="img-fluid">
                                </div>
                                <p class="tituloSearchesVideo">{{ miVideo.snippet.title }}</p>
                                <p class="fechaSearchesVideo">Publicado el {{ miVideo.snippet.publishTime.substring(8, 10) + "-" + miVideo.snippet.publishTime.substring(5, 7) + "-" + miVideo.snippet.publishTime.substring(0, 4) }}</p>
                                <p class="descripSearchesVideo">{{ miVideo.snippet.description }}</p>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        name: 'Viewvideo',
        props: {
            video_details: {
                type: String,
                required: true
            }
        },
        data(){
            return {
                idvideo: '',
                palabrasClaves: '',
                link_video: '',
                titulo_video: '',
                fecha_publicado: '',
                descripcion: '',
                //
                listaVideos: [],
                isLoading: false,
                fullPage: true
            }
        },
        components: {
            Loading
        },
        created(){
            this.updateVideo_details();
        },
        mounted(){
            this.getListaVideos();
        },
        watch: {
            video_details(){
                this.updateVideo_details();
                this.getListaVideos();
            }
        },
        methods: {
            updateVideo_details(){
                this.idvideo = JSON.parse(this.video_details).idvideo;
                this.palabrasClaves = JSON.parse(this.video_details).keywords;
                this.link_video = "https://www.youtube.com/embed/" + this.idvideo;
                this.titulo_video = JSON.parse(this.video_details).titulovideo;
                this.fecha_publicado = JSON.parse(this.video_details).publicado;
                this.descripcion = JSON.parse(this.video_details).descripcion;
            },
            async getListaVideos(){
                this.isLoading = true;
                let opcionBusqueda = {
                    search_query: this.palabrasClaves,
                    page_token: '',
                    order: 'viewCount',
                    video_definition: '',
                    video_duration: ''
                };
                await this.axios.post('/api/videos', opcionBusqueda)
                    .then((result) => {
                        this.listaVideos = result.data.items;
                        this.isLoading = false;
                    });
            },
        }
    }
</script>