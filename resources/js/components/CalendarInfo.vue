<template>
  <div>
    <div v-if="calendar">
      <div class="alert alert-secondary" role="alert" v-if="!calendar.live_url">
        <div class="alert-icon"><div class="kt-spinner kt-spinner--v2 kt-spinner--lg kt-spinner--dark"></div></i>
        </div>
        <div class="alert-text" style="margin-left:2rem;">    Synchronizing your Google calendar...</div>
        <div class="alert-close">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
              <i class="la la-close"></i>
            </span>
          </button>
        </div>
      </div>
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
          <input
            type="text"
            class="form-control"
            id="calendar_url"
            placeholder="ICS Calendar"
            :value="calendar.url"
            readonly
          />
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button" @click="copy('calendar_url')">
              <i class="flaticon2-copy"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label>Live Calendar</label>
        <div class="input-group">
          <div
            v-if="!calendar.live_url"
            class="kt-spinner kt-spinner--v2 kt-spinner--sm kt-spinner--success kt-spinner--right kt-spinner--input"
          >
            <input
              type="text"
              class="form-control"
              id="calendar_live_url"
              placeholder="Live Calendar"
              :value="calendar.live_url"
              readonly
            />
          </div>

          <input
            v-if="calendar.live_url"
            type="text"
            class="form-control"
            id="calendar_live_url"
            placeholder="Live Calendar"
            :value="calendar.live_url"
            readonly
          />
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button" @click="copy('calendar_live_url')">
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
      calendar: null,
      interval: null
    };
  },
  methods: {
    loadData: function() {
      window.axios
        .get(`/calendar`)
        .then(response => {
          if (response.status === 200) {
            this.calendar = response.data;
            if (this.calendar.live_url) {
              clearInterval(this.interval);
            }
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    copy: id => {
      var copyText = document.getElementById(id);

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
    this.interval = setInterval(
      function() {
        this.loadData();
      }.bind(this),
      2500
    );
  },

  beforeDestroy: function() {
    clearInterval(this.interval);
  }
};
</script>

<style scoped>
</style>
