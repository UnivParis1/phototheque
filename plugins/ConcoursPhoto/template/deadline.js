Vue.filter("two_digits", function(value) {
    if (value.toString().length <= 1) {
        return "0" + value.toString();
    }
    return value.toString();
});

Vue.component("countdown", {
    template: "#countdown-template",

    props:['duration'],
    data() {
        return {
            now: new moment().format('X')
        }
    },
    computed: {
        normalizedDate() {
            let a = this.duration.split(' ');
            return new moment().add(a[0], a[1]).format('X');
        },

        diff() {
            return this.normalizedDate - this.now;
        },

        seconds() {
            return this.diff % 60;
        },

        minutes() {
            return Math.trunc(this.diff / 60) % 60;
        },

        hours() {
            return Math.trunc(this.diff / 60 / 60) % 24;
        },

        days() {
            return Math.trunc(this.diff / 60 / 60 / 24);
        },

        clSeconds() {
            if(this.days > 0) {
                return { green: true }
            } else if(this.hours > 0) {
                return { yellow: true }
            } else if (this.minutes > 0) {
                return { orange: true }
            } else if (this.seconds > 0) {
                return { red: true }
            }
        },

        clMinutes() {
            if(this.days > 0) {
                return { green: true }
            } else if(this.hours > 0) {
                return { yellow: true }
            } else if (this.minutes > 0) {
                return { orange: true }
            }
        },

        clHours() {
            if(this.days > 0) {
                return { green: true }
            } else if(this.hours > 0) {
                return { yellow: true}
            }
        },

        clDays() {
            if(this.days > 0) {
                return { green: true }
            }
        }
    },
    methods: {
        moment() {
            return moment();
        },
        updateTime() {
            if (this.diff > 0) {
            	this.now = new moment().format('X');
                setTimeout(this.updateTime, 1000);
            }
        }
    },
    mounted() {
        this.updateTime();
    },
});

new Vue({
    el: "#countdown"
});
