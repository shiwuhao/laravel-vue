<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta id="token" value="{{ csrf_token() }}">
        <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">

        <title>Laravel</title>

    </head>
    <body>
        <div class="container">
            <tasks-app></tasks-app>
        </div>

        <template id="tasks-template">
            <form class="form-group" @submit="createTask">
                <input type="text" class="form-control" v-model="notes">
                <button type="submit" class="btn btn-success btn-block">Create Task</button>
            </form>
            <h1>My Tasks</h1>
            <ul class="list-group">
                <li class="list-group-item" v-for="task in list | orderBy 'id' -1">
                    @{{ task.body }}
                    <strong @click="deleteTask(task)">X</strong>
                </li>
            </ul>
        </template>
    </body>
    <script src="https://cdn.bootcss.com/vue/1.0.14/vue.js"></script>
    <script src="https://cdn.bootcss.com/vue-resource/1.1.1/vue-resource.min.js"></script>
    <script>
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
        var resource = Vue.resource('api/tasks/{id}');
        Vue.component('tasks-app', {
            template:'#tasks-template',
            props:['list', 'notes'],
            data:function () {
                return {
                    notes:'',
                    list:[]
                }
            },
            created:function () {
                var vm = this;
                this.$http.get('api/tasks').then(function(response){
                    vm.list = response.data;
                }, function (response) {
                    alert('error');
                });
            },
            methods:{
                deleteTask:function (task) {
                    resource.delete({id:task.id}).then(function(){

                    }, function () {
                        alert('error')
                    }).bind(this);
                    this.list.$remove(task);
                },
                createTask:function (e) {
                    e.preventDefault();
                    this.$http.post('api/tasks', {body:this.notes}).then(function (response) {
                        this.list.push(response.task);
                    }, function () {
                        alert('error');
                    }).bind(this);
                }
            }
        });

        new Vue({
            el:'.container',

        });
    </script>
</html>
