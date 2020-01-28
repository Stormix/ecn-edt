<template>
  <div>
    <div v-if="calendar">
      <p>
        Calendar name:
        <b>{{ calendar.name }}</b>
      </p>
      <p>
        Last sync:
        <b>{{calendar.updated_at}}</b>
      </p>
      <br />
      <div class="form-group">
        <label>ICS Calendar</label>
        <div class="input-group">
          <input type="text" class="form-control" id="calendar_url" placeholder="ICS Calendar" :value="calendar.url" readonly/>
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button" @click="copy()">
              <i class="flaticon2-copy"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      calendar: null
    };
  },
  methods: {
    loadData: function() {
      window.axios
        .get(`/calendar`)
        .then(response => {
          if (response.status === 200) {
            this.calendar = response.data;
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    copy: () => {
      var copyText = document.getElementById("calendar_url");

      copyText.select();
      copyText.setSelectionRange(0, 99999); /*For mobile devices*/

      /* Copy the text inside the text field */
      document.execCommand("copy");
      toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: false,
        progressBar: false,
        positionClass: "toast-top-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
      };

      toastr.success("Copied to clipboard!");
    }
  },
  mounted() {
    this.loadData();
  }
};
</script>

<style scoped>
</style>
