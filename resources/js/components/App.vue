<template>
    <main>
        <nav class="navbar navbar-expand-lg navbar-secondary bg-secondary miNavbar">
            <div class="container contenidoNavbar">    
                <div class="areaBrand">
                    <router-link to="/" class="navbar-brand">
                        <div class="imag">
                            <img :src="asset('/logo_net-app.png')" width="60px" height="60px" >
                        </div>
                    </router-link>      
                    <!--<a class="navbar-brand" href="#">
                        <div class="imag">
                            <img :src="asset('/logo_net-app.png')" width="60px" height="60px" >
                        </div>
                    </a>-->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="misEnlaces">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 margenDerecho">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle textoDropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Categorias
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                   <!-- <li><a class="dropdown-item" href="#">Fisica</a></li> -->
                                    <li>
                                        <router-link exact-active-class="active" class="dropdown-item" :to="{ name: 'searches', params: { details: JSON.stringify( { category: 'Matemática', keywords: 'matematica matemática' } ) } }">
                                            Matemática
                                        </router-link>
                                    </li>

                                    <li>
                                        <router-link exact-active-class="active" class="dropdown-item" :to="{ name: 'searches', params: { details: JSON.stringify( { category: 'Química', keywords: 'quimica química' } ) } }">
                                            Química
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link exact-active-class="active" class="dropdown-item" :to="{ name: 'searches', params: { details: JSON.stringify( { category: 'Desarrollo Web', keywords: 'desarrollo web' } ) } }">
                                            Desarrollo Web
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link exact-active-class="active" class="dropdown-item" :to="{ name: 'searches', params: { details: JSON.stringify( { category: 'Programación', keywords: 'programacion programación' } ) } }">
                                            Programación
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <form class="d-flex areaBusqueda">
                            <label for="TextBusqueda" class="col-sm-2 col-form-label me-4">Buscar</label>
                            <input id="TextBusqueda" class="form-control me-2 inputBusqueda" type="text" v-model="keywords" >
                            <router-link exact-active-class="active" class="btn btn-success" :to="{ name: 'searches', params: { details: JSON.stringify( { category: 'Consulta', keywords: keywords } ) } }">
                                <span class="fa-solid fa-search spanBusqueda"></span>
                            </router-link>
                        </form>
                    </div>
                </div>
                <div class="areaUsuario">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle usuarioDropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fa-solid fa-user spanUsuario"></span>
                                {{ user.name }} 
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#" @click.prevent="logout()">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="areaContenido">
            &nbsp;
            <router-view></router-view>
            
        </div>
    </main>
</template>

<script> 
    let user = document.head.querySelector('meta[name="user"]');
    
    export default {
        data(){
            return {
                keywords: ''
            }
        },
        mounted(){
            this.$router.push({name: "home"});
        },
        methods: {
            logout() {
                axios.post('/logout')
                    .then(response => {
                        window.location.href = '/login';
                    });
            }
        },
        computed: {
            user(){
                return JSON.parse(user.content);
            }
        }
    }
</script>