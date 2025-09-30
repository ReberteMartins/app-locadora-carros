<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


                <!-- Inicio do card de busca -->
                <card-component titulo="Buscar de Marcas">

                        <template v-slot:conteudo>
                            <div class="row">
                                <div class="col mb-3">
                                    <input-container-component titulo="ID" id="inputId" id-help="IdHelp" texto-ajuda="Informe o ID da marca">
                                        <input type="number" class="form-control" id="InputId" aria-describedby="idHelp" placeholder="ID">
                                    </input-container-component>
                                </div>

                                <div class="col mb-3">
                                    <input-container-component titulo="Nome da marca" id="InputNome" id-help="nomeHelp" texto-ajuda="Informe o nome do registro">
                                        <input type="text" class="form-control" id="InputNome" aria-describedby="nomeHelp" placeholder="Nome da Marca">
                                    </input-container-component>

                                </div>
                            </div>
                        </template>

                        <template v-slot:rodape>
                            <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
                        </template>

                </card-component>
                <!-- Fim do card de busca -->



                <!-- Inicio do card de listagem de marcas -->
                <card-component titulo="Relação de Marcas">

                        <template v-slot:conteudo>
                            <table-component v-if="marcas.data" :dados="marcas.data" :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                created_at: {titulo: 'Data de criação', tipo: 'data'},
                            }"
                            >
                            </table-component>
                        </template>

                        <template v-slot:rodape>
                            <div class="row">
                                <div class="col-10">
                                    <paginate-component>
                                            <li v-for="l, key in marcas.links" :key="key"
                                                :class="l.active ? 'page-item active' : 'page-item'"
                                                @click="paginacao(l)"
                                            >
                                                <a class="page-link" v-html="l.label"></a>
                                            </li>
                                    </paginate-component>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
                                </div>
                            </div>
                        </template>

                </card-component>

                <!-- Fim do card de listagem de marcas -->

            </div>
        </div>
        <!-- Button trigger modal -->

        <!-- Modal -->
        <modal-component id="modalMarca" titulo="Adicionar Marca">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" texto="Sucesso ao cadastrar" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" texto="Erro ao cadastrar" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>


            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome do registro">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da Marca" v-model="nomeMarca">
                    </input-container-component>
                    {{ nomeMarca}}
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Slecione uma imagem no formato PNG">
                        <input type="file" class="form-control" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                    {{arquivoImagem}}
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>

            </template>
        </modal-component>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                urlBase: 'http://localhost:8000/api/marca',
                config: {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                },
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                marcas: {data: []}
            }
        },
        methods:{
            paginacao(l){
                if(l.url) {
                    this.urlBase = l.url
                    this.carregarLista()
                }
            },
            carregarLista(){
                axios.get(this.urlBase, this.config)
                    .then(response => {
                        this.marcas = response.data
                        console.log(this.marcas)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            carregarImagem(e){
                this.arquivoImagem = e.target.files
            },
            salvar(){
                console.log( this.token)

                let formData = new FormData();
                formData.append('nome', this.nomeMarca)
                formData.append('imagem', this.arquivoImagem[0])

                // let config = {
                //     headers: {
                //         'Content-Type': 'multipart/form-data',
                //         'Accept': 'application/json',
                //         'Authorization': `Bearer ${localStorage.getItem('token')}`
                //     }
                // }

                // URL | Conteudo | Configuração
                axios.post( this.urlBase, formData, this.config).then(response=> {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: "ID do registro: "+response.data.id
                    }
                    console.log(response)
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem:errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                    console.log(errors)
                })
            }
        },
        mounted(){
            this.carregarLista()
        }
    }
</script>
