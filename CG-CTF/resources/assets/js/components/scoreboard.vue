<template>
 <div id="scoreboard">
        <board-bar></board-bar>
<div class="container">
<table class="table table-hover" style="table-layout:fixed" v-show="activeboard === 'fresh'">
  <caption>Score Board</caption>
   <thead>
      <tr>
         <th>rank</th>
         <th>name</th>
      <th>score</th>
      <th>time</th>
      </tr>
   </thead>

    <tbody v-for ="(user,index) in fresh">
      <tr @click="detail(user.id)">
         <td>{{user.rank}}</td>
         <td style="overflow:hidden" >{{user.name}}</td>
      <td>{{user.totalScore}}</td>
      <td>{{user.lastsubtime.date.slice(0,-6)}}</td>
     </tr>
   </tbody>

</table>
<table class="table table-hover" style="table-layout:fixed" v-show="activeboard === 'old'">
  <caption>Score Board</caption>
   <thead>
      <tr>
         <th>rank</th>
         <th>name</th>
      <th>score</th>
      <th>time</th>
      </tr>
   </thead>

    <tbody v-for ="(user,index) in old">
      <tr @click="detail(user.id)">
         <td>{{user.rank}}</td>
         <td style="overflow:hidden" >{{user.name}}</td>
      <td>{{user.totalScore}}</td>
      <td>{{user.lastsubtime.date.slice(0,-6)}}</td>
     </tr>
   </tbody>

</table>
<table class="table table-hover" style="table-layout:fixed" v-show="activeboard === 'all'">
  <caption>Score Board</caption>
   <thead>
      <tr>
         <th>rank</th>
         <th>name</th>
      <th>score</th>
      <th>time</th>
      </tr>
   </thead>

    <tbody v-for ="(user,index) in all">
      <tr @click="detail(user.id)">
         <td>{{user.rank}}</td>
         <td style="overflow:hidden" >{{user.name}}</td>
      <td>{{user.totalScore}}</td>
      <td>{{user.lastsubtime.date.slice(0,-6)}}</td>
     </tr>
   </tbody>

</table>
</div>
</div>
</template>


<script>
    import boardBar from './BoardBar.vue';
    import eventHub from "../eventHub"

    export default {
        name: "scoreboard",
        props: ['login'],
        data: () => ({
            activeboard: 'fresh',
            routeList,
            loadStatus: {},
            fresh: [],
            old: [],
            all: [],
        }),
        methods: {
            loadData(board) {
                axios.get(`${apiRoot}scoreboard?class=${board}`)
                    .then((response) => {
                        this[board] = response.data;
                        this.loadStatus[board] = true;
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            },
            detail(id){
                var url=routeList.get('teamdetail')+'/'+id;
                location.href=url;
            },
            setActiveboard(board) {
                if (!this.hasData(board)) {
                    this.loadData(board)
                }
                this.activeboard = board
            },
            hasData(board) {
                return !!this.loadStatus[board]
            },
            justWaitForACoffee() {
                return new Promise(resolve => {
                    setTimeout(() => resolve('☕'), 2000); // it takes 2 seconds to make coffee
                });
            },
            async loadAllData() {
                try {
                    let boards = ['fresh', 'old', 'all'];
                    let currentboard = location.href.split('/scoreboard#')[1];
                    boards = boards.filter(board => board !== currentboard);

                    const coffee = await this.justWaitForACoffee();
                    // then we grab some data
                    let promises = [];
                    for (let board of boards) {
                        promises.push(axios(`${apiRoot}scoreboard?class=${board}`))
                    }
                    // await all promises to come back and destructure the result into their own variables
                    let responses = [];
                    responses = await Promise.all(promises);
                    for (let i = 0; i < responses.length; i++) {
                        this[boards[i]] = responses[i].data
                    }
                    for (let board of boards) {
                        this.loadStatus[board] = true;
                    }
                } catch (error) {
                    console.error(error);
                }
            }
        },
        created() {
            let currentboard = location.href.split('/scoreboard#')[1];
            this.setActiveboard(currentboard);
            eventHub.$on('activeboard', (activeboard) => {
                this.setActiveboard(activeboard);
            });
            eventHub.$on('challenge.delete', id => {
               let type = this.activeboard;
               this[type] = this[type].filter(item => item.id !== id)
            });
        },
        mounted() {
            this.loadAllData()
        },
        components: {
            boardBar
        }
    }
</script>
