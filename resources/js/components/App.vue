<template>
    <main>
        <nav class="navbar navbar-expand-lg navbar-secondary bg-secondary miNavbar">
            <div class="container contenidoNavbar">    
                <div class="areaBrand">      
                    <a class="navbar-brand" href="#">
                        <div class="imag">
                            <img :src="asset('/logo_net-app.png')" width="60px" height="60px" >
                        </div>
                    </a>
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
                                    <li><a class="dropdown-item" href="#">Fisica</a></li>
                                    <li><a class="dropdown-item" href="#">Matematica</a></li>
                                    <li><a class="dropdown-item" href="#">Quimica</a></li>
                                    <li><a class="dropdown-item" href="#">Programacion</a></li>
                                </ul>
                            </li>
                        </ul>
                        <form class="d-flex areaBusqueda">
                            <label for="TextBusqueda" class="col-sm-2 col-form-label me-4">Buscar</label>
                            <input id="TextBusqueda" class="form-control me-2 inputBusqueda" type="text">
                            <button class="btn btn-success" type="button">
                                <span class="fa-solid fa-search spanBusqueda"></span>
                            </button>
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
    </main>
</template>

<script> 
    let user = document.head.querySelector('meta[name="user"]');
    
    export default {
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