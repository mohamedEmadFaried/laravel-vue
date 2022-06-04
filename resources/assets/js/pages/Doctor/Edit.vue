<template>
  <modal-layouts name="editRecord" id="editRecord">
    <template slot="heading">Edit Record</template>

    <template slot="main">
      <div class="form-group">
        <label for="name">Name</label>

        <input
          type="text"
          name="name"
          id="name"
          class="form-control"
          v-model="editRec.name"
          @keydown="delete errors.name"
        />

        <span v-if="errors.name" class="text-danger">
          <small v-text="errors.name[0]"></small>
        </span>
      </div>

    </template>

    <template slot="footer">
      <button
        type="button"
        class="btn btn-outline-secondary"
        @click="clearModal"
        data-dismiss="modal"
      >
        Close
      </button>

      <button
        type="submit"
        class="btn btn-outline-primary"
        @click="updateRecord"
      >
        Save Changes
      </button>
    </template>
  </modal-layouts>
</template>

<script>
import ModalLayouts from "../../partials/ModalLayouts";

export default {
  props: ["editRec"],

  data() {
    return {
      errors: [],
    };
  },

  components: { ModalLayouts },

  methods: {
    updateRecord() {
      axios
        .put(`/doctors/${this.editRec.id}`, this.editRec)
        .then((response) => {
          this.$emit("recordUpdated", response);

          toast({
            type: "success",
            title: "Record has been updated successfully!",
          });

          $("#editRecord").modal("hide");
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },

    clearModal() {
      this.errors = [];
    },
  },
};
</script>