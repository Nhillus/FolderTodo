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
                        <v-card height="50">
                            <v-list-item-content v-on:click.prevent="selecionarActividad(actividad.id,actividad.nombre)" >
                              <v-list-item-title>
                              {{todo.nombre}}
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
      valid:false,
      todoList: {
        id:'',
        nombre:'',
      },
      todoSelecionado: {
        id:'',
        nombre:'',
      },
      actividadAEliminar:null,
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
          this.folderSelecionado.id = idTodo; //1 refactor entre estas dos funciones 
          this.folderSelecionado.nombre = nombreTodo;
          this.actividadAEliminar = idActividad;

          //this.verActividades();
          console.log(this.folderSelecionado.id, this.folderSelecionado.nombre );

        },
    }
  }
</script>