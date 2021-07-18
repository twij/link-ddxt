<template>
    <div class="" @paste="onPaste" @copy="copyRedirect" @keyup.enter="handleEnter">
        <div class="center-content">
          <img src="/img/ddxtcc.png" alt="ddxtcc" class="object-center">
          <input type="text" v-model="url" id="url-box">
          <button type="button" class="btn-blue" v-on:click="createRedirect" v-show="!complete">Shorten</button>
          <button type="button" class="btn-green" v-on:click="copyRedirect" v-show="complete">{{copyText}}</button>
          <span class="copy-success" v-if="copySuccess">Copied</span>
          <div class="error-text" v-if="error">{{ error }}</div>
        </div>
    </div>
</template>

<style scoped>

</style>

<script>
  import axios from 'axios'
  export default {
    props: {
      canLogin: Boolean,
      canRegister: Boolean,
      laravelVersion: String,
      phpVersion: String,
    },
    data() {
      return {
        url: null,
        previous: null,
        complete: false,
        error: null,
        copyText: 'Copy',
        copySuccess: false
      }
    },
    watch: {
      url: function (val) {
        if (val != this.previous) {
          this.complete = false
        }
      }
    },
    methods: {
      async createRedirect () {
        if (this.url !== this.previous) {
          try {
            const res = await axios.post('/api', {url: this.url})
            this.url = res.data.url
            this.previous = this.url
            this.complete = true
            this.copyText = 'Copy'
          } catch (error) {
            this.error = 'Unable to shorten URL'
          }
        }
      },
      async copyRedirect () {
        let urlToCopy = document.querySelector('#url-box')
        urlToCopy.setAttribute('type', 'text')
        urlToCopy.select()

        try {
          document.execCommand('copy')
          this.copyText = 'Copied'
        } catch (err) {
          this.error= "Unable to copy :("
        }
      },
      onPaste (evt) {
        this.url = evt.clipboardData.getData('text')
        this.createRedirect()
      },
      handleEnter() {
        if (this.complete) {
          this.copyRedirect()
        } else {
          this.createRedirect()
        }
      }
    }
  }
</script>
