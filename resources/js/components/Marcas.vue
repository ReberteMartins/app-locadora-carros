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
                                        <input type="number" class="form-control" id="InputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                    </input-container-component>
                                </div>

                                <div class="col mb-3">
                                    <input-container-component titulo="Nome da marca" id="InputNome" id-help="nomeHelp" texto-ajuda="Informe o nome do registro">
                                        <input type="text" class="form-control" id="InputNome" aria-describedby="nomeHelp" placeholder="Nome da Marca" v-model="busca.nome">
                                    </input-container-component>

                                </div>
                            </div>
                        </template>

                        <template v-slot:rodape>
                            <button type="submit" class="btn btn-primary btn-sm float-end" @click="pesquisar()">Pesquisar</button>
                        </template>

                </card-component>
                <!-- Fim do card de busca -->



                <!-- Inicio do card de listagem de marcas -->
                <card-component titulo="Relação de Marcas">

                        <template v-slot:conteudo>
                            <table-component v-if="marcas.data"
                            :dados="marcas.data"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaVisualizar'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaAtualizar'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaRemover'}"
                            :titulos="{
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

        <!-- Modal de visualização de Marca -->
        <modal-component id="modalMarcaVisualizar" titulo="Visualizar marca">
            <template v-slot:alertas>

            </template>

            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome da marca">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>

                <input-container-component titulo="Imagem">
                    <img v-if="$store.state.item.imagem" :src="'storage/' + $store.state.item.imagem" alt="Logo">
                </input-container-component>

                <input-container-component titulo="Data de Criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                </input-container-component>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>

            </template>
        </modal-component>

        <!-- Modal de Remoção de Marca -->
        <modal-component id="modalMarcaRemover" titulo="Remover marca">
            <template v-slot:alertas>
                <alert-component tipo="success" texto="Transação realizada com sucesso" :detalhes="{mensagem: ''}" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" texto="Erro na transação" :detalhes="{mensagem: ''}" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome da marca">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>

            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>

            </template>
        </modal-component>

        <!-- Modal de Atualizacao de Marca -->
        <modal-component id="modalMarcaAtualizar" titulo="Atualizar marca">
            <template v-slot:alertas>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o nome do registro">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome da Marca" v-model="nomeMarca">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp" texto-ajuda="Slecione uma imagem no formato PNG">
                        <input type="file" class="form-control" id="atualizarImagem" aria-describedby="atualizarImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>

            </template>
        </modal-component>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                urlBase: 'http://localhost:8000/api/marca',
                urlPaginacao: '',
                urlFiltro: '',
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
                marcas: {data: []},
                busca: { id: '', nome: ''}
            }
        },
        methods:{
            remover(){
                let url = this.urlBase + '/' + this.$store.state.item.id

                let formData = new FormData();
                formData.append('_method', 'delete')

                axios.post(url, formData, this.config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response,data.erro
                    })
            },
            pesquisar() {
                 let filtro = ''

                 for(let chave in this.busca) {

                    if (this.busca[chave]) {

                        if(filtro != ''){
                            filtro += ';'
                        }

                        filtro += chave + ':like:' + this.busca[chave]
                    }
                 }

                 if (filtro != '') {
                    this.urlPaginacao = 'page=1'
                     this.urlFiltro = '&filtro='+filtro
                    //  console.log(this.urlFiltro)
                 }else{
                    this.urlFiltro = ''
                 }
                 this.carregarLista()
            },
            paginacao(l){
                if(l.url) {
                    // this.urlBase = l.url
                    this.urlPaginacao = l.url.split('?')[1]
                    this.carregarLista()
                    // console.log(l.url.split('?')[1])
                }
            },
            carregarLista(){
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

                // axios.get(this.urlBase, this.config)
                axios.get(url, this.config)
                    .then(response => {
                        this.marcas = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            carregarImagem(e){
                this.arquivoImagem = e.target.files
            },
            salvar(){

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
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem:errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                })
            },
            atualizar(){
                console.log(this.$store.state.item)
            }
        },
        mounted(){
            this.carregarLista()
        }
    }
</script>
