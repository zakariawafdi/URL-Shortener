
<template>
  <div class="container">
    <form @submit.prevent="shortenUrl" class="row g-3 mt-3">
      <div class="col-12">
        <label for="longUrl">Long URL:</label>
      </div>
      <div class="col-10">
        <input type="text" id="longUrl" v-model="longUrl" class="form-control" placeholder="Enter long URL" required>
      </div>
      <div class="col-2">
        <button type="submit" class="btn btn-primary">Shorten</button>
      </div>
    </form>
    <div v-if="shortUrl" class="alert alert-success mt-4">
    <p class="mb-0">Short URL:</p>
    <div class="url-container">
      <a :href="'/url/' + shortUrl" target="_blank">{{ currentHost + '/url/' + shortUrl }}</a>
      <button @click="copyToClipboard" class="copy-button">
        <i class="fas fa-copy"></i>
      </button>
    </div>
  </div>
  </div>
</template>

<style>
.container {
  max-width: 800px;
  margin: 0 auto;
}

label{
  font-weight: bold;
}
input[type="text"] {
  width: 100%;
}

.alert {
  padding: 1rem;
  border-radius: 0.25rem;
}

.alert p {
  margin-bottom: 0;
}

.alert a {
  color: #007bff;
  text-decoration: none;
}

.copy-button {
  background: none;
  border: none;
  margin-left: 8px;
  cursor: pointer;
  font-size: 16px;
  color: #007bff;
}
</style>


<script>
export default {
  data() {
    return {
      longUrl: '',
      shortUrl: '',
      currentHost: ''
    }
  },
  methods: {
    shortenUrl() {
      axios.post('/api/shorten', { long_url: this.longUrl })
        .then(response => {
          this.shortUrl = response.data.shortUrl;
        })
        .catch(error => {
          console.log(error);
        });
    },
    copyToClipboard() {
      const urlElement = document.createElement("textarea");
      urlElement.value = this.currentHost + "/url/" + this.shortUrl;
      document.body.appendChild(urlElement);
      urlElement.select();
      document.execCommand("copy");
      document.body.removeChild(urlElement);
    }
  },
  mounted() {
    this.currentHost = window.location.host;
  }
}
</script>