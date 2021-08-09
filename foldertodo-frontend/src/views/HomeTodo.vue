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

        <v-responsive max-width="260">
          <v-text-field
            dense
            flat
            hide-details
            rounded
            solo-inverted
          ></v-text-field>
        </v-responsive>
      </v-container>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <v-row>
          <v-col cols="2">
            <v-sheet rounded="lg">
              <v-list color="transparent">
                <v-list-item
                  v-for="n in 5"
                  :key="n"
                  link
                >
                  <v-list-item-content>
                    <v-list-item-title>
                      List Item {{ n }}
                    </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>

                <v-divider class="my-2"></v-divider>

                <v-list-item
                  link
                  color="grey lighten-4"
                >
                  <v-list-item-content>
                    <v-list-item-title>
                      Refresh
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
                        cols="11"
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
                        <v-card height="70">
                            <v-list-item-content v-on:click.prevent="selecionarTodo(todo.id,todo.nombre)" >
                              <v-list-item-title>
                                <v-btn icon fab>
                                  <v-checkbox @click.prevent="modificarEstatus()"
                                    v-model="todo.estado" 
                                    color="success"
                                    value=1
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
  export default {
    name:"HomeTodo",
    data: () => ({
      links: [
        'Dashboard',
      ],
      dialog:false,
      valid:false,
      todoList: {
        id:'',
        nombre:'',
      },
      todoSelecionado: {
        id:'',
        nombre:'',
      },
      todoAModificar:null,
      todoAEliminar:null,
      todos: {},
      folderTodoRules: [
        v => !!v || 'Name is required',
        v => v.length <= 10 || 'Name must be less than 10 characters',
      ],  
    }),
    async created() { 
     try {
            const response = await axios.get('http://localhost:8000/api/todos')
            this.todos = response.data.todos
        } catch (e) {
            // handle the error here
        }
    },
    methods: {
      agregarTodo() {
          axios
          .post('http://localhost:8000/api/agregartodo',this.todoList)
          .then((response) => {
            if (response.status == 201) {
                  this.todos.push(response.data.todo);
            }
              console.log(response);
          }); 

        },
        selecionarTodo(idTodo,nombreTodo) {
          this.todoSelecionado.id = idTodo; //1 refactor entre estas dos funciones 
          this.todoSelecionado.nombre = nombreTodo;
          this.todoAEliminar = idTodo;

          //this.verActividades();
          console.log(this.todoSelecionado.id, this.todoSelecionado.nombre );

        },
        modificarTodo() {
          this.todoList.id = this.todoSelecionado.id;
          axios
            .put('http://localhost:8000/api/modificartodo',this.todoList)
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
        modificarEstatus() {
         
        },
        estaEliminando(id) {
          this.todoAEliminar = id;
        },
        async eliminarTodo(id) {
          let index = this.todos.findIndex(todo => todo.id === id)
           await axios
            .delete('http://localhost:8000/api/eliminartodo'+'/'+ id)  
            .then((response) => {
              this.todos.splice(index,1);
              console.log(response);
              
          });
        }
    }
  }
</script>