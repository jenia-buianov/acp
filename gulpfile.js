var gulp = require('gulp');
// Requires the gulp-sass plugin
var sass = require('gulp-sass');

gulp.task('sass', function() {
    return gulp.src('public/assets/custom/scss/**/*.scss') // Gets all files ending with .scss in app/scss and children dirs
        .pipe(sass())
        .pipe(gulp.dest('public/assets/custom/css/'))
       
});

gulp.task('default', function(){
    gulp.watch('public/assets/custom/scss/**/*.scss', ['sass']);
    // Other watchers
});