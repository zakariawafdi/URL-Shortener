<template>
  <div class="short-url-stats">
    <div class="short-url-list">
      <h2>Short URLs</h2>
      <table>
        <thead>
          <tr>
            <th>Short URL</th>
            <th>Original URL</th>
            <th>Clicks</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="shortUrl in paginatedShortUrls" :key="shortUrl.id" @click="showStats(shortUrl.short_url)">
            <td>{{ currentHost + '/url/'+ shortUrl.short_url }}</td>
           <td>
                <span v-if="shortUrl.long_url <= 30">{{ shortUrl.long_url }}</span>
                <span v-else>{{ shortUrl.long_url.slice(0, 30) }}...</span>
            </td>
            <td>{{ shortUrl.click_count }}</td>
          </tr>
        </tbody>
      </table>
      <div class="pagination">
        <button :disabled="currentPage === 1" @click="currentPage--">Previous</button>
        <span>{{ currentPage }}</span>
        <button :disabled="currentPage === Math.ceil(shortUrls.length / perPage)" @click="currentPage++">Next</button>
      </div>
    </div>
    <div class="most-visited">
      <h2>10 Most Visited Short URLs</h2>
      <table>
        <thead>
          <tr>
            <th>Short URL</th>
            <th>Original URL</th>
            <th>Clicks</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="shortUrl in mostVisited" :key="shortUrl.id" @click="showStats(shortUrl.short_url)">
            <td>{{ currentHost + '/url/'+ shortUrl.short_url }}</td>
            <!-- <td>{{ shortUrl.long_url }}</td> -->
            <td><span v-if="shortUrl.long_url <= 30">{{ shortUrl.long_url }}</span>
                <span v-else>{{ shortUrl.long_url.slice(0, 30) }}...</span></td>
            <td>{{ shortUrl.click_count }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pop-up" v-if="showPopUp" @click="showPopUp = false; pshortUrl= {}">
      <!-- Pop-up content -->
      <div class="pop-up-content">
        <h2>{{ pshortUrl.shorturl }} Statistics</h2>
        <p>Week Clicks: {{ pshortUrl.weekClicks }}</p>
        <p>Month Clicks: {{ pshortUrl.monthClicks }}</p>
        <p>Year Clicks: {{ pshortUrl.yearClicks }}</p>
</div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentHost: '',
      shortUrls: [],
      mostVisited: [],
      showPopUp: false,
      pshortUrl: {
        shorturl: '',
        weekClicks: '',
        monthClicks: '',
        yearClicks: '',

      },
      currentPage: 1,
      perPage: 10
    };
  },
  methods: {
    showStats(shortUrl) {
      // Show pop-up with statistics for the short URL

      this.getShortUrlStatistics(shortUrl);

      this.showPopUp = true;
    },

    getstats() {
      axios.get('/api/stats')
        .then(response => {
          this.shortUrls = response.data.allShortened;
          this.mostVisited = response.data.mostVisitedUrls;
        })
        .catch(error => {
          console.log(error);
        });
    },

    getShortUrlStatistics(shorturl) {
      axios.get('/api/short-url-statistics/'+shorturl)
        .then(response => {
          this.pshortUrl.shorturl = shorturl;
          this.pshortUrl.weekClicks = response.data.weekClicks;
          this.pshortUrl.monthClicks = response.data.monthClicks;
          this.pshortUrl.yearClicks = response.data.yearClicks;
        })
        .catch(error => {
          console.log(error);
        });
    },


  },
  mounted() {
    this.currentHost = this.currentHost = window.location.protocol +"//" + window.location.host;
    this.getstats();
  },
  computed: {
    paginatedShortUrls() {
      const start = (this.currentPage - 1) * this.perPage;
      const end = start + this.perPage;
      return this.shortUrls.slice(start, end);
    }
  },
};
</script>

<style scoped>
.short-url-stats {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

.short-url-list {
  width: 49%;
}

.most-visited {
  width: 49%;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

tr:hover {
  background-color: #f5f5f5;
}

.pop-up {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.pop-up-content {
  background-color: white;
  padding: 16px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

.pagination {
  display: flex;
  justify-content: center;
  margin-top: 16px;
}

.pagination button {
  margin: 0 8px;
  padding: 8px;
  border: none;
  border-radius: 4px;
  background-color: #007bff;
  color: white;
  cursor: pointer;
}

.pagination button:disabled {
  background-color: #ccc;
  cursor: default;
}

.pagination span {
  margin: 0 8px;
  font-weight: bold;
}

</style>