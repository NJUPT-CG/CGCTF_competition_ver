<template>
    <div class="challenge-card" v-if="show">
        <mu-paper class="challenge-item" :zDepth="1">
            <mu-appbar :title="challenge.title"/>
            <mu-float-button icon="add" mini @click="open"/>
            <mu-card-actions>
                <mu-flat-button :label="challenge.score + 'pt'"/>
                <mu-flat-button v-if="challenge.passed" class="passed" label="passed" @click="showSolvers"/>
            </mu-card-actions>
        </mu-paper>

        <mu-dialog v-if="dialog" :open="dialog" :title="challenge.title" @close="close">
            <mu-card>
                <mu-card-actions class="solvers-wrapper">
                    <mu-flat-button :label="'solvers: ' + challenge.solversCount" @click="showSolvers"/>
                </mu-card-actions>
                <mu-card-title :subTitle="challenge.class + ' ' + challenge.score + 'pt'"/>
                <mu-divider/>
                <mu-card-text v-html="challenge.description"></mu-card-text>
                <mu-card-actions>
                    <mu-flat-button v-if="challenge.url" label="题目地址" @click="reference"/>
                </mu-card-actions>
                <mu-text-field label="FLAG" v-model="flagInput" labelFloat/>
            </mu-card>
            <mu-flat-button v-if="challenge.power" slot="actions" :href="routeList.get('edit') +'/' + challenge.id"
                            primary label="编辑"/>
            <mu-flat-button v-if="challenge.power" slot="actions" @click="deleteChallenge" primary label="删除"/>
            <mu-flat-button slot="actions" @click="close" primary label="取消"/>
            <mu-flat-button slot="actions" primary @click="submitFlag" label="提交"/>
        </mu-dialog>

        <mu-dialog v-if="solversDialog" :open="solversDialog" title="ALL SOLVERS" @close="solversClose">
            <mu-card>
                <mu-list>
                    <mu-sub-header>
                        <span class="titleDesc">solver</span>
                        <span class="subtitleDesc">time</span>
                    </mu-sub-header>
                    <mu-list-item v-for="(item, index) in solvers" :key="index">
                        <span class="title">{{ item.name }}</span>
                        <span class="subtitle">{{ item.pivot.created_at }}</span>
                    </mu-list-item>
                </mu-list>
            </mu-card>
            <mu-flat-button slot="actions" @click="solversClose" primary label="关闭"/>
        </mu-dialog>

        <mu-popup position="top" :overlay="false" :class="{ 'popup-success': submitStat }" popupClass="demo-popup-top"
                  :open="topPopup">
            {{ result }}
        </mu-popup>
    </div>
</template>

<script>
    import eventHub from '../eventHub'

    export default {
        name: "challengeCard",
        props: ['challengeBaseInfo'],
        data: () => ({
            challenge: {},
            dialog: false,
            solversDialog: false,
            routeList,
        }),
        created() {
            this.challenge = this.challengeBaseInfo;
        },
        methods: {
            open() {
                if (!this.challenge.class) {
                    axios.get(`${apiRoot}challenge/detail/${this.challenge.id}`)
                        .then(response => {
                            this.challenge = Object.assign(this.challenge, response.data);
                            this.challenge.description = window.md.render(this.challenge.description);
                            this.flagInput = null;
                            this.dialog = true;
                        })
                        .catch((error) => {
                            console.log(error)
                        })
                } else {
                    this.flagInput = null;
                    this.dialog = true;
                }
            },
            reference() {
                window.open(this.challenge.url, "_blank")
            },
        watch: {
            }
        }
    }
</script>
