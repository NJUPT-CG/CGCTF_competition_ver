<template>
    <div id="boards">
        <mu-tabs :value="activeboard" @change="handleboardChange">
            <mu-tab value="fresh" :href="routeList.get('scoreboard.fresh')" title="校内队"/>
            <mu-tab value="old" :href="routeList.get('scoreboard.old')" title="校外队"/>
            <mu-tab value="all" :href="routeList.get('scoreboard.all')" title="总榜"/>
        </mu-tabs>
    </div>
</template>

<script>
    import eventHub from "../eventHub"

    export default {
        name: "BoardBar",
        data: () => ({
            activeboard: 'fresh',
            routeList
        }),
        methods: {
            handleboardChange(val) {
                this.activeboard = val;
                eventHub.$emit('activeboard', this.activeboard)
            }
        },
        created() {
            this.activeboard = location.href.split('/scoreboard#')[1]
            eventHub.$on('activeboard', (activeboard) => {
                this.activeboard = activeboard;
            })
        }
    }
</script>
