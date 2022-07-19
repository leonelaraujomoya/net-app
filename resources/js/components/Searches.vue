<template>
    <div v-if="isLoading">
        <loading v-model:active="isLoading"
            :can-cancel="true"
            :on-cancel="onCancel"
            :is-full-page="fullPage"/>
    </div>
    <div v-else class="container mt-4 areaResult">
        <div class="row">
            <div class="col">
                <h5 v-if="categoria === 'Consulta'" class="tituloResultados">Videos encontrados relacionados a "{{ palabrasClaves }}"</h5>
                <h5 v-else class="tituloResultados">Videos encontrados relacionados a la categoria "{{ categoria }}"</h5>
                <div class="linkFiltros" v-on:click="filtrar">
                    <p><span class="fa-solid fa-sliders-h spanSearchesOpciones"></span></p>
                    <p>FILTROS</p>
                </div>
                <hr class="linea" />
                <div class="row opcionesFiltro" v-if="filtro">
                    <div class="col-4">
                        <p class="tituloOpcionFiltro">DURACIÓN</p>
                        <hr class="lineas" />
                        <ul class="ulOpciones">
                            <li class="liopcionesFiltro">
                                <p v-on:click="fmenos" v-if="menos">Menos de 4 minutos&nbsp;&nbsp;&nbsp;<span class="fa-solid fa-check-circle"></span></p>
                                <p v-on:click="fmenos" v-else>Menos de 4 minutos</p>
                            </li>
                            <li class="liopcionesFiltro">
                                <p v-on:click="fentre" v-if="entre">Entre 4 y 20 minutos&nbsp;&nbsp;&nbsp;<span class="fa-solid fa-check-circle"></span></p>
                                <p v-on:click="fentre" v-else>Entre 4 y 20 minutos</p>
                            </li>
                            <li class="liopcionesFiltro">
                                <p v-on:click="fmas" v-if="mas">Más de 20 minutos&nbsp;&nbsp;&nbsp;<span class="fa-solid fa-check-circle"></span></p>
                                <p v-on:click="fmas" v-else>Más de 20 minutos</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <p class="tituloOpcionFiltro">CARACTERÍSTICAS</p>
                        <hr class="lineas" />
                        <ul class="ulOpciones">
                            <li class="liopcionesFiltro">
                                <p v-on:click="fchd" v-if="chd">Alta definición - HD&nbsp;&nbsp;&nbsp;<span class="fa-solid fa-check-circle"></span></p>
                                <p v-on:click="fchd" v-else>Alta definición - HD</p>
                            </li>
                            <li class="liopcionesFiltro">
                                <p v-on:click="fcsta" v-if="csta">Resolución estándar&nbsp;&nbsp;&nbsp;<span class="fa-solid fa-check-circle"></span></p>
                                <p v-on:click="fcsta" v-else>Resolución estándar</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <p class="tituloOpcionFiltro">ORDENAR POR</p>
                        <hr class="lineas" />
                        <ul class="ulOpciones">
                            <li class="liopcionesFiltro">
                                <p v-on:click="frel" v-if="rel">Relevancia&nbsp;&nbsp;&nbsp;<span class="fa-solid fa-check-circle"></span></p>
                                <p v-on:click="frel" v-else>Relevancia</p>
                            </li>
                            <li class="liopcionesFiltro">
                                <p v-on:click="ffec" v-if="fec">Fecha de subida&nbsp;&nbsp;&nbsp;<span class="fa-solid fa-check-circle"></span></p>
                                <p v-on:click="ffec" v-else>Fecha de subida</p>
                            </li>
                            <li class="liopcionesFiltro">
                                <p v-on:click="fnum" v-if="num">Número de visualizaciones&nbsp;&nbsp;&nbsp;<span class="fa-solid fa-check-circle"></span></p>
                                <p v-on:click="fnum" v-else>Número de visualizaciones</p>
                            </li>
                            <li class="liopcionesFiltro">
                                <p v-on:click="fpun" v-if="pun">Puntuación&nbsp;&nbsp;&nbsp;<span class="fa-solid fa-check-circle"></span></p>
                                <p v-on:click="fpun" v-else>Puntuación</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr class="linea" v-if="filtro" /> 
                
                <h5 v-if="noexisten" class="videosNoEncontrados">No se encontraros videos relacionados"</h5>

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
                <hr class="linea" />
                <div class="areaPaginacion">
                    <button v-if="this.anterior === ''" type="button" class="btn btn-primary btn-sm" disabled>Anteriores</button>
                    <button v-else type="button" class="btn btn-primary btn-sm" v-on:click="buscarAnteriores">Anteriores</button>
                    <div class="areaPagActual"><p class="pagActual">[ {{ nPagina }} ]</p></div>
                    <button v-if="this.siguiente === ''" type="button" class="btn btn-primary btn-sm" v-on:click="buscarSiguientes" disabled>Siguientes</button>
                    <button v-else type="button" class="btn btn-primary btn-sm" v-on:click="buscarSiguientes">Siguientes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        name: 'Searches',
        props: {
            details: {
                type: String,
                required: true
            }
        },
        data(){
            return {
                categoria: "",
                palabrasClaves: "",
                listaVideos: [],
                noexisten: true,
                nPagina: 1,
                siguiente: "",
                anterior: "",
                filtro: false,
                duracion: 'any',
                caracteristica: 'any',
                orden: '',
                menos: false,
                entre: false, 
                mas: false,
                chd: false,
                csta: false, 
                rel: false,
                fec: false,
                num: false,
                pun: false,
                isLoading: false,
                fullPage: true
            }
        },
        components: {
            Loading
        },
        created(){
            this.updateDetails();
        },
        mounted(){
             this.getListaVideos();
        },
        watch: {
            details(){
                this.updateDetails();
                this.getListaVideos();
            }
        },
        methods: {
            updateDetails(){
                this.categoria = JSON.parse(this.details).category;
                this.palabrasClaves = JSON.parse(this.details).keywords;
            },
            filtrar(){
                this.filtro = !this.filtro;
            },
            fmenos(){
                if(this.menos){
                    this.duracion = 'any';
                    this.menos = false;
                }else{
                    this.duracion = 'short';
                    this.menos = true;
                    this.entre = false;
                    this.mas = false;
                }
                this.getListaVideos();
            },
            fentre(){
                if(this.entre){
                    this.duracion = 'any';
                    this.entre = false;
                }else{
                    this.duracion = 'medium';
                    this.menos = false;
                    this.entre = true;
                    this.mas = false;
                }
                this.getListaVideos();
            },
            fmas(){
                if(this.mas){
                    this.duracion = 'any';
                    this.mas = false;
                }else{
                    this.duracion = 'long';
                    this.menos = false;
                    this.entre = false;
                    this.mas = true;
                }
                this.getListaVideos();
            },
            fchd(){
                if(this.chd){
                    this.caracteristica = 'any';
                    this.chd = false;
                }else{
                    this.caracteristica = 'high';
                    this.chd = true;
                    this.csta = false;
                }
                this.getListaVideos();
            },
            fcsta(){
                if(this.csta){
                    this.caracteristica = 'any';
                    this.csta = false;
                }else{
                    this.caracteristica = 'standard';
                    this.chd = false;
                    this.csta = true;
                }
                this.getListaVideos();
            },
            async frel(){
                if(this.rel){
                    this.orden = '';
                    this.rel = false;
                }else{
                    this.orden = 'relevance';
                    this.rel = true;
                    this.fec = false;
                    this.num = false;
                    this.pun = false;
                }
                this.getListaVideos();
            },
            async ffec(){
                if(this.fec){
                    this.orden = '';
                    this.fec = false;
                }else{
                    this.orden = 'date';
                    this.rel = false;
                    this.fec = true;
                    this.num = false;
                    this.pun = false;
                }
                this.getListaVideos();
            },
            async fnum(){
                if(this.num){
                    this.orden = '';
                    this.num = false;
                }else{
                    this.orden = 'viewCount';
                    this.rel = false;
                    this.fec = false;
                    this.num = true;
                    this.pun = false;
                }
                this.getListaVideos();
            },
            async fpun(){
                if(this.pun){
                    this.orden = '';
                    this.pun = false;
                }else{
                    this.orden = 'rating';
                    this.rel = false;
                    this.fec = false;
                    this.num = false;
                    this.pun = true;
                }
                this.getListaVideos();
            },
            async getListaVideos(){
                this.isLoading = true;
                let opcionBusqueda = {
                    search_query: this.palabrasClaves,
                    page_token: this.siguiente,
                    order: this.orden,
                    video_definition: this.caracteristica,
                    video_duration: this.duracion
                };
                await this.axios.post('/api/videos', opcionBusqueda)
                    .then((result) => {
                        this.listaVideos = result.data.items;
                        if(this.listaVideos !== []){
                            this.noexisten = false;
                        }else{
                            this.noexisten = true;
                        }
                        if (typeof result.data.nextPageToken === "string") {
                            this.siguiente = result.data.nextPageToken;
                        }else{
                            this.siguiente = "";
                        }
                        this.anterior = "";
                        this.isLoading = false;
                        this.nPagina = 1;
                    });
            },
            async buscarSiguientes(){
                this.isLoading = true;
                let opcionBusqueda = {
                    search_query: this.palabrasClaves,
                    page_token: this.siguiente,
                    order: this.orden,
                    video_definition: this.caracteristica,
                    video_duration: this.duracion
                };
                await this.axios.post('/api/videos', opcionBusqueda)
                    .then((result) => {
                        this.listaVideos = result.data.items;
                        if (typeof result.data.nextPageToken === "string") {
                            this.siguiente = result.data.nextPageToken;
                        }else{
                            this.siguiente = "";
                        }
                        if (typeof result.data.prevPageToken === "string") { 
                            this.anterior = result.data.prevPageToken;
                        }else{
                            this.anterior = "";
                        }
                        this.isLoading = false;
                        this.nPagina = this.nPagina + 1;
                    });
            },
            async buscarAnteriores(){
                this.isLoading = true;
                let opcionBusqueda = {
                    search_query: this.palabrasClaves,
                    page_token: this.anterior,
                    order: this.orden,
                    video_definition: this.caracteristica,
                    video_duration: this.duracion
                };
                await this.axios.post('/api/videos', opcionBusqueda)
                    .then((result) => {
                        this.listaVideos = result.data.items;
                        if (typeof result.data.nextPageToken === "string") {
                            this.siguiente = result.data.nextPageToken;
                        }else{
                            this.siguiente = "";
                        }
                        if (typeof result.data.prevPageToken === "string") { 
                            this.anterior = result.data.prevPageToken;
                        }else{
                            this.anterior = "";
                        }
                        this.isLoading = false;
                        this.nPagina = this.nPagina - 1;
                    });
            }
        }
    }
</script>