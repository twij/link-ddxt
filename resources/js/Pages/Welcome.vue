<template>
    <div class="" @paste="onPaste">
        <!-- <div v-if="canLogin" class="admin-links">
            <inertia-link v-if="$page.props.user" href="/dashboard" class="admin-link">
                Dashboard
            </inertia-link>

            <template v-else>
                <inertia-link :href="route('login')" class="admin-link">
                    Log in
                </inertia-link>

                <inertia-link v-if="canRegister" :href="route('register')" class="admin-link">
                    Register
                </inertia-link>
            </template>
        </div> -->

        <div class="center-content">
          <img src="/img/ddxtcc.png" alt="ddxtcc" class="object-center">
          <input type="text" v-model="url" id="url-box" @keyup.enter="createRedirect">
          <button type="button" class="btn-blue" v-on:click="createRedirect" v-show="!complete">Shorten</button>
          <button type="button" class="btn-green" v-on:click="copyRedirect" v-show="complete">Copy</button>
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
        complete: false,
        error: null,
        copySuccess: false
      }
    },
    methods: {
      async createRedirect () {
        try {
          const res = await axios.post('/api', {url: this.url})
          this.url = res.data.url
          this.complete = true
        } catch (error) {
          this.error = 'Unable to shorten URL'
        }
      },
      async copyRedirect () {
        let urlToCopy = document.querySelector('#url-box')
        urlToCopy.setAttribute('type', 'text')
        urlToCopy.select()

        try {
          document.execCommand('copy')
          this.copySuccess = true
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
