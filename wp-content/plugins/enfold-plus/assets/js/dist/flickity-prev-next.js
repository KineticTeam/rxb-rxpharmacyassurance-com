/* Flickity prev next */
function changeSlideClasses(e,s,i){e&&e.getCellElements().forEach(function(e){e.classList[s](i)})}Flickity.createMethods.push("_createPrevNextCells"),Flickity.prototype._createPrevNextCells=function(){this.on("select",this.setPrevNextCells)},Flickity.prototype.setPrevNextCells=function(){changeSlideClasses(this.previousSlide,"remove","is-previous"),changeSlideClasses(this.nextSlide,"remove","is-next"),this.previousSlide=this.slides[this.selectedIndex-1],this.nextSlide=this.slides[this.selectedIndex+1],changeSlideClasses(this.previousSlide,"add","is-previous"),changeSlideClasses(this.nextSlide,"add","is-next")};