<template>
  <v-app id="inspire">
    <v-app-bar
      app
      color="white"
      flat
    >
      <v-container class="py-0 fill-height">
        <v-avatar
          class="mr-10"
          color="grey darken-1"
          size="32"
        ></v-avatar>

        <v-btn
          v-for="link in links"
          :key="link"
          text
        >
          {{ link }}
        </v-btn>

        <v-spacer></v-spacer>

        
      </v-container>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <v-row>
          <v-col cols="4">
            <v-sheet rounded="lg">
              <v-form v-model="valid" v-on:submit.prevent="agregarFolder()">
                <v-container>
                  <v-row>
                    <v-col
                      cols="12"
                    >
                      <v-text-field
                        v-model="folderTodo.nombre"
                        :rules="folderTodoRules"
                        :counter="10"
                        label="Todo Folder"
                        required
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-form>
              <v-list >
              <v-list-item
                v-for="(folder,idx) in folders "
                :key="idx"
                link
              >
                <v-list-item-content >
                  <v-list-item-title class="text-justify" v-on:click.prevent="selecionarFolder(folder.id,folder.nombre)">
                  {{ folder.nombre }}
                    <v-btn color="primary" class="ml-2" icon fab x-small >
                      <v-col cols="auto">
                            <v-btn
                              color="primary"
                              class="ml-2"
                              icon fab 
                              
                            ><v-icon v-on:click="dialogFolder = true" >mdi-folder-edit</v-icon>
                            </v-btn>
                          <v-dialog
                            transition="dialog-top-transition"
                            max-width="600"
                            v-model="dialogFolder"
                            :retain-focus="false"
                          >
                            <v-card>
                              <v-toolbar
                                color="primary"
                                dark 
                              >Modificando {{folderSelecionado.nombre}}</v-toolbar>
                              <v-card-text>
                                <v-text-field
                                  v-model="folderTodo.nombre"
                                  :rules="folderTodoRules"
                                  :counter="10"
                                  label="Todo Folder"
                                  required
                                ></v-text-field>                        
                              </v-card-text>
                              <v-card-actions class="justify-end">
                                <v-btn
                                  text
                                  :rules="folderTodoRules"
                                  :counter="10"
                                  @click="modificarFolder()"
                                >Modificar</v-btn>
                                <v-btn
                                  text
                                @click="dialogFolder = false">Cancelar</v-btn>
                              </v-card-actions>
                            </v-card>
                        </v-dialog>
                      </v-col>
                    </v-btn>
                    <v-btn
                    icon fab
                    color="red darken-4"
                    @click="estaEliminando(folder.id)"
                    >
                      <v-icon >
                        mdi-delete  
                      </v-icon>
                      <v-dialog
                        persistent
                        max-width="300"
                        v-model="dialogDelete"
                        :retain-focus="false"
                      >
                        <v-card>
                          <v-toolbar
                            color="red accent-4"
                            dark 
                          >
                          <v-card-title class="text-h6">
                            ¿Estas seguro que desea eliminar esta carpeta?
                          </v-card-title>
                          </v-toolbar>
                          <v-card-text>
                            <v-card-text>Al eliminar la carpeta eliminaras todos los items que contiene ¿Deseas continuar? </v-card-text>                        
                          </v-card-text>
                          <v-card-actions >
                            <v-spacer></v-spacer>
                            <v-btn
                              color="green darken-1"
                              text
                              @click="eliminarFolder(folderAEliminar)"
                            >
                              Confirmar
                            </v-btn>
                            <v-btn
                              color="green darken-1"
                              text
                              @click="dialogDelete = false"
                            >
                              Cancelar
                            </v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                    </v-btn>
                    <v-btn
                     icon fab
                     x-small
                     color="blue-grey lighten-3">
                      <v-col>
                        <v-btn
                        @click.prevent="cargarTodo(folder.id,folder.nombre)"
                        class="ml-2"
                        icon fab
                        color="blue-grey lighten-3" >
                          <v-icon>
                            mdi-folder-download                          
                          </v-icon>
                        </v-btn>
                      </v-col>
                    </v-btn>
                    <v-btn
                    icon fab
                    color="light-green darken-3"
                    >
                      <v-col>
                        <v-btn
                        class="ml-2"
                        icon fab
                        color="green darken-4"
                        @click.prevent="estaSelecionando(folder.id)"
                        >
                          <v-icon>
                            mdi-file-plus
                          </v-icon>
                        </v-btn>
                      </v-col>
                    </v-btn>
                  <!----------------------------------------------------------------------------------------- ------------------------------------------------------------->
                        <v-dialog
                          v-model="dialogAdd"
                          scrollable
                          max-width="300px"
                          :retain-focus="false"
                        >
                          <v-card>
                            <v-card-title>Select Country</v-card-title>
                            <v-divider></v-divider>
                            <v-card-text style="height: 300px;">
                              <v-radio-group
                                v-model="folderAddTodo.idT"
                                column
                              >
                                <v-radio
                                v-for="(todo,idx) in todosSinAgrupar"
                                :key="idx"
                                :label="todo.nombre"
                                :value="todo.id"
                                ></v-radio>
                              </v-radio-group>
                            </v-card-text>
                            <v-divider></v-divider>
                            <v-card-actions>
                              <v-btn
                                color="blue darken-1"
                                text
                                @click="dialogAdd = false"
                              >
                                Close
                              </v-btn>
                              <v-btn
                                color="blue darken-1"
                                text
                                @click="agregarTodoAFolder()"
                              >
                                Save
                              </v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>
                  <!----------------------------------------------------------------------------------------- ------------------------------------------------------------->
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider class="my-2"></v-divider>

              <v-list-item
                link
                color="grey lighten-4"
              >
                <v-list-item-content @click.prevent="todosLosTodos()">
                  <v-list-item-title>
                    Ver Todos los Todos
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list>
            </v-sheet>
          </v-col>

          <v-col>
            <v-sheet
              min-height="70vh"
              rounded="lg"
            >
              <!--  -->
              <v-main>
                <v-form v-model="valid" v-on:submit.prevent="agregarTodo()"> 
                  <v-container>
                    <v-row>
                      <v-col
                        cols="9"
                      >
                        <v-text-field
                          v-if="!dialog"
                          v-model="todoList.nombre"
                          :rules="folderTodoRules"
                          :counter="10"
                          label="Todo List"
                          required
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col
                        v-for="(todo,idx) in todos"
                        :key="idx"
                        cols="4"
                      >
                        <v-card height="100" >
                            <v-list-item-content v-on:click.prevent="selecionarTodo(todo.id,todo.nombre,todo.estado)" >
                              <v-list-item-title>
                                <v-btn icon fab>
                                  <v-checkbox @click.prevent="modificarEstatus(todo.id,todo.nombre,todo.estado)"
                                    v-model="todo.estado"
                                    color="success"
                                    value="true"
                                  ></v-checkbox>
                                </v-btn>
                                  {{todo.nombre}}
                                  <v-btn color="primary" class="ml-2" icon fab x-small >
                                    <v-col cols="auto">
                                      <v-btn
                                        color="primary"
                                        class="ml-2"
                                        icon fab 
                                        
                                      ><v-icon v-on:click="dialog = true" >mdi-file-document-edit</v-icon>
                                      </v-btn>
                                      <v-btn color="primary"  icon fab x-small >
                                        <v-col>
                                          <v-btn
                                            icon fab
                                            color="red darken-4"
                                            @click="eliminarTodo(todo.id)"
                                            >
                                              <v-icon >
                                                mdi-delete-forever  
                                              </v-icon>
                                          </v-btn>
                                        </v-col>
                                      </v-btn>
                                      <v-dialog
                                        transition="dialog-top-transition"
                                        max-width="600"
                                        v-model="dialog"
                                        :retain-focus="false"
                                      >
                                      <v-card>
                                        <v-toolbar
                                          color="primary"
                                          dark 
                                        >Modificando {{todoSelecionado.nombre}}</v-toolbar>
                                        <v-card-text>
                                          <v-text-field
                                            v-model="todoList.nombre"
                                            :rules="folderTodoRules"
                                            :counter="10"
                                            label="Todo Folder"
                                            required
                                          ></v-text-field>                        
                                        </v-card-text>
                                        <v-card-actions class="justify-end">
                                          <v-btn
                                            text
                                            :rules="folderTodoRules"
                                            :counter="10"
                                            @click="modificarTodo()"
                                          >Modificar</v-btn>
                                          <v-btn
                                            text
                                          @click="dialog = false">Cancelar</v-btn>
                                        </v-card-actions>
                                      </v-card>
                                    </v-dialog>
                                  </v-col>
                                </v-btn>
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-card>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-form>
              </v-main>
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
  import axios from 'axios'
  import { API_BASE_URL } from '../services/config' 
  export default {
    name:"HomeTodo",
    data: () => ({
      links: [
        'FolderTodo',
      ],
      dialogAdd:false,
      dialogFolder:false,
      dialogDelete:false,
      dialog:false,
      valid:false,
      folderTodo: {
        id:'',
        nombre:'',
      },
      folderSelecionado: {
        id:'',
        nombre:'',
      },
      todoList: {
        id:'',
        nombre:'',
        estado:'',
      },
      todoSelecionado: {
        id:'',
        nombre:'',
        estado:'',
      },
      folderAddTodo: {
        idF:'',
        idT:'',
      },
      folderSelecionada: null,
      folderAModificar:null,
      folderAEliminar:null,
      todoAModificar:null,
      todoAEliminar:null,
      todoEstado:null,
      dialogm1: '',
      folders: {},
      todos: {},
      todosSinAgrupar: {},
      folderTodoRules: [
        v => !!v || 'Name is required',
        v => v.length <= 10 || 'Name must be less than 10 characters',
      ], 
    
    }),
    async created() { 
     try {
            const responseF = await axios.get(API_BASE_URL +'/folders')
            this.folders = responseF.data.Folders
            const response = await axios.get(API_BASE_URL +'/todos')
            this.todos = response.data.todos
            
        } catch (e) {
            // handle the error here
        }
    },
    methods: {
      agregarFolder() {
          axios
          .post(API_BASE_URL + '/agregarfolder',this.folderTodo)
          .then((response) => {
            if (response.status == 201) {
                  this.folders.push(response.data.Folder);
            }
              console.log(response);
          }); 

        },
      agregarTodo() {
          axios
          .post(API_BASE_URL+'/agregartodo',this.todoList)
          .then((response) => {
            if (response.status == 201) {
                  this.todos.push(response.data.todo);
            }
              console.log(response);
          }); 

        },
        selecionarFolder(idFolder,nombreFolder) { 
          this.folderSelecionado.id = idFolder; //1 refactor entre estas dos funciones 
          this.folderSelecionado.nombre = nombreFolder;
          this.folderAEliminar = idFolder;

          //this.verActividades();
          console.log(this.folderSelecionado.id, this.folderSelecionado.nombre );


        },
        selecionarTodo(idTodo,nombreTodo,estadoTodo) {
          this.todoSelecionado.id = idTodo; //1 refactor entre estas dos funciones 
          this.todoSelecionado.nombre = nombreTodo;
          this.todoSelecionado.estado = estadoTodo;
          this.todoEstado = estadoTodo;
          this.todoAEliminar = idTodo;
          this.todoAModificar = idTodo;


          //this.verActividades();
          console.log(this.todoSelecionado.id, this.todoSelecionado.nombre,this.todoSelecionado.estado );

        },
        modificarFolder() {
          this.folderTodo.id = this.folderSelecionado.id;
          axios
            .put(API_BASE_URL + '/modificarfolder',this.folderTodo)
            .then((response) => {
            if (response.status == 200) {
                  //this.actividades.put(response.data.Actividad);
                  this.folderAModificar = this.folderTodo.id;
                  console.log(this.todoAModificar);
                  let objIndex = this.folders.findIndex((obj => obj.id ==this.folderAModificar));
                  this.folders[objIndex].nombre = this.folderTodo.nombre;
                  console.log(objIndex);
                  this.dialogFolder = false;
            }
              console.log(response);
          }); 
        },
        modificarTodo() {
          this.todoList.id = this.todoSelecionado.id;
          axios
            .put(API_BASE_URL + '/modificartodo',this.todoList)
            .then((response) => {
            if (response.status == 200) {
                  //this.actividades.put(response.data.Actividad);
                  this.todoAModificar = this.todoList.id;
                  console.log(this.todoAModificar);
                  let objIndex = this.todos.findIndex((obj => obj.id ==this.todoAModificar));
                  this.todos[objIndex].nombre = this.todoList.nombre;
                  console.log(objIndex);
                  this.dialog = false;
            }
              console.log(response);
          }); 
        },
        async modificarEstatus(id,nombre,estado) {
          this.todoList.id = id;
          this.todoList.nombre = nombre;
          this.todoList.estado = estado;
         await axios
            .put(API_BASE_URL + '/modificartodoestado', this.todoList)
            .then((response) => {
              if (response.status == 200) {
                this.todoAModificar = this.todoList.id;
                console.log(this.todoAEliminar);
                let objIndex = this.todos.findIndex((obj => obj.id == id)); 
                this.todos[objIndex].estado = this.todoList.estado;
                console.log(objIndex)              
                }
              console.log(response);
            })
         
        },
        estaEliminando(id) {
          this.todoAEliminar = id;
          this.dialogDelete = true;
        },

        async eliminarFolder(id) {
          let index = this.folders.findIndex(folder => folder.id === id)
           await axios
            .delete(API_BASE_URL + '/eliminarfolder'+'/'+ id)  
            .then((response) => {
              this.folders.splice(index,1);
              this.dialogDelete = false;
              console.log(response);
          });
        },

        async eliminarTodo(id) {
          let index = this.todos.findIndex(todo => todo.id === id)
           await axios
            .delete(API_BASE_URL + '/eliminartodo'+'/'+ id)  
            .then((response) => {
              this.todos.splice(index,1);
              console.log(response);
              
          });
        },
        async cargarTodo(id) {
          await axios
            .get(API_BASE_URL + '/cargartodos'+'/'+ id)
            .then((response) => {
              this.todos.splice(0,this.todos.length);
              this.todos = response.data.todosInFolders
              console.log(response);
            });
        },
        async todosLosTodos() {
         try {
            const response = await axios.get('http://localhost:8000/api/todos')
            this.todos = response.data.todos
         } catch (error) {
           //handle error
         }
         
        },
        async estaSelecionando(id) {
             this.dialogAdd=true;
            this.folderAddTodo.idF=id;
            const response = await axios.get('http://localhost:8000/api/todossingrupo')
            this.todosSinAgrupar = response.data.todosWithoutGroup;
            console.log(response);
              //handle error
        },
          
        agregarTodoAFolder() {
          axios
          .put(API_BASE_URL + '/agregartodoafolder',this.folderAddTodo)
          .then((response)=> {
            this.dialogAdd=false;
            console.log(response);
          });
        }
    }
  }
</script>