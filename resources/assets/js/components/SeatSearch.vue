<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        I'm an example component!
                    </div>
                    <!-- <input v-model="message" placeholder="edit me">
                      <p>Message is: @{{ message }} </p> -->
                    <form>
                       <select v-model="selected">
                          <option>A</option>
                          <option>B</option>
                          <option>C</option>
                        </select>
                        <span>Selected: {{ selected }} </span>                       
                      <!-- <button type="submit" class="btn btn-default">Submit</button> -->
                      
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Seat seach Component ready.')
        }
    }
</script>
