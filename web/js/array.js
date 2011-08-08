Array.prototype.inArray = function(val) {
  var l = this.length;
  for(var i = 0; i < l; i++) {
    if(this[i] == val) {
      return true;
    }
  }
  return false;
}