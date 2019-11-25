<template>
    <div class="container">
        <div class="display">
            <div class="row justify-content-center">
                <div class="col-md-4 text-center">
                    <transition name="fade">
                        <div v-if="senhaChamada" class="senha-chamada">
                            Senha chamada <br>
                            <span class="senha">{{ senhaChamada }}</span>
                        </div>

                        <div v-if="!calledFirst" class="senha-chamada">
                            Aguarde a chamada
                        </div>
                    </transition>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4" v-for="fila in filas">
                <div class="card" v-if="hasSenhas(fila)">
                    <div class="card-header">{{ fila.nome }}</div>

                    <div class="card-body" v-if="fila.senhas_chamadas.length">
                        Chamada:

                        {{ fila.senhas_chamadas[0].valor }}
                    </div>

                    <div class="card-body" v-if="fila.senhas_chamadas.length > 1">
                        Últimas:

                        <ul>
                            <li v-for="(senha, key) in fila.senhas_chamadas" v-if="key > 0">
                                {{ senha.valor }}
                            </li>
                        </ul>
                    </div>


                    <div class="card-footer">
                        Próximas:

                        <ul>
                            <li v-for="senha in fila.senhas_ordenadas">
                                {{ senha.valor }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.25s ease-out;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }

    .senha-chamada {
        font-size: 24px;
        color: red;
        text-transform: uppercase;
    }

    .senha-chamada .senha {
        font-size: 36px;
        animation: pisca 3s;
        padding: 10px;
    }

    .display {
        height: 180px;
    }

    @keyframes pisca {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
        }
    }
</style>

<script>
    export default {

        data() {
            return {
                filas: [],
                senhaChamada: null,
                calledFirst: false
            }
        },
        mounted() {
            this.loadFilas();

            Echo.channel('filas')
                .listen('SenhaChamadaEvent', (e) => {
                    this.loadFila(e.senha.fila.id);
                    this.call(e.senha);
                });

            Echo.channel('filas')
                .listen('NovaSenhaGeradaEvent', (e) => {
                    this.loadFila(e.senha.fila_id);
                });
        },

        methods: {

            call(senha) {
                this.senhaChamada = null;

                setTimeout(() => {
                    this.senhaChamada = senha.valor;

                    if(this.calledFirst) {
                        this.calledFirst = true;
                    }
                }, 500);
            },

            loadFilas(){
                axios
                    .get('api/filas')
                    .then((res) => {
                        res.data.data.forEach((fila) => {
                            this.loadFila(fila.id);
                        });
                    })
            },

            loadFila(fila) {
                axios
                    .get('api/filas/' + fila)
                    .then((res) => {
                        if(!this.updateFila(res.data.data)) {
                            this.filas.push(res.data.data);
                        }
                    })
            },

            updateFila(fila) {
                var exists = false;

                this.filas.forEach((f, k) => {
                    if(f.id === fila.id) {
                        this.filas[k] = Object.assign(this.filas[k], fila);

                        exists = true;
                    }
                });

                return exists;
            },

            hasSenhas(fila) {
                return fila.senhas_chamadas.length > 0 || fila.senhas_ordenadas.length > 0;
            }

        }
    }
</script>
