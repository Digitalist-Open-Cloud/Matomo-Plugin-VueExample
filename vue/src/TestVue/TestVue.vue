<!--
  Matomo - free/libre analytics platform

  @link    https://matomo.org
  @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
-->

<template>
  <h3>{{ contentTitle }}</h3>
  <div class="example-vue">
    <button v-on:click="decrement">-</button>
    {{ count }}
    <button v-on:click="increment">+</button>

    <MatomoDialog v-model="showDialog">
      <div class="ui-confirm exampleDialog">
        <h2>Alert</h2>
        <p>
          The count is greater than 15 right now!
        </p>

        <input type="button" value="OK" role="yes"/>
      </div>
    </MatomoDialog>
  </div>
</template>

<style lang="less" scoped>
  .example-component {
    display: flex;
    justify-content: center;
    align-items: center;

    button {
      background-color: indigo;
      color: white;
      margin: 8px;
    }
  }
</style>

<script lang="ts">
import { defineComponent } from 'vue';
import { MatomoDialog } from 'CoreHome';

interface TestVueState {
  count: number;
  showDialog: boolean;
}

export default defineComponent({
  props: {
    contentTitle: String,
  },
  components: {
    MatomoDialog,
  },
  data(): TestVueState {
    return {
      count: 12,
      showDialog: false,
    };
  },
  methods: {
    increment() {
      this.count += 1;
      this.showDialog = this.count > 15;
    },
    decrement() {
      this.count -= 1;
      this.showDialog = this.count > 15;
    },
  },
});
</script>
