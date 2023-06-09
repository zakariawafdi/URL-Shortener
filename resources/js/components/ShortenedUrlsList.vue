<template>
  <div class="shortened-urls">
    <h2 class="mb-4">Previously Shortened URLs</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Short URL</th>
          <th>Original Long URL</th>
          <th>Click Count</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(url, index) in shortenedUrls" :key="index">
          <td><a :href="currentHost + '/url/'+ url.short_url" target="_blank" class="short-url">{{ currentHost + '/url/'+ url.short_url }}</a></td>
          <td><a :href="url.long_url" target="_blank" class="short-url">{{ url.long_url }}</a></td>
          <td><span class="badge bg-primary click-count">{{ url.click_count }} clicks</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style>
.shortened-urls {
  font-family: Arial, sans-serif;
}

.shortened-urls h2 {
  font-size: 24px;
  color: #333;
}

.shortened-urls .table {
  width: 100%;
  border-collapse: collapse;
}

.shortened-urls th,
.shortened-urls td {
  padding: 10px;
  border-bottom: 1px solid #ccc;
}

.shortened-urls th {
  background-color: #f8f9fa;
  text-align: left;
}

.shortened-urls .short-url {
  color: #007bff;
  text-decoration: none;
}

.shortened-urls .click-count {
  font-size: 14px;
  color: #fff;
  background-color: #007bff;
  padding: 4px 8px;
  border-radius: 4px;
}
</style>



<script>
export default {
  data() {
    return {
      currentHost: '',
      shortenedUrls: []
    }
  }, methods: {
    getShortenedUrls() {
      axios.get('/api/list')
        .then(response => {
          this.shortenedUrls = response.data.urls;
        })
        .catch(error => {
          console.log(error);
        });
    },
  },mounted(){
    this.currentHost = this.currentHost = window.location.protocol +"//" + window.location.host;
    this.getShortenedUrls();
  }

}
</script>

<style scoped>
h2 {
  margin-bottom: 1rem;
}

.list-group-item {
  border: none;
}

.badge {
  font-size: 1rem;
}
</style>