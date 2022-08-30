let mobileTouch = {
    getDirection(startX, startY, endX, endY) {
        let dy = startY - endY;
        let result = 0;
        if (dy > 0) {
            //向上滑动
            result = 1;
        } else if (dy < 0) {
            //向下滑动
            result = 2;
        } else {
            result = 0;
        }
        console.log(result)
        return result;
    },
    listentouch() {
        let startX, startY;
        document.addEventListener(
            "touchstart",
            function(ev) {
                startX = ev.touches[0].pageX;
                startY = ev.touches[0].pageY;
            },
            false
        );
        document.addEventListener(
            "touchmove",
            function(ev) {
                let endX, endY;
                endX = ev.changedTouches[0].pageX;
                endY = ev.changedTouches[0].pageY;
                this.getDirection(startX, startY, endX, endY);
            },
            false
        );
        return this;
    }
}


