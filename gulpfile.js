const gulp = require('gulp'),
      //rename = require('gulp-rename');
      sass = require('gulp-sass'),
      //concat = require('gulp-concat'),
      sourcemaps = require('gulp-sourcemaps'),
      browserSync = require('browser-sync').create();

const styleSrc = './assets/sass/**/*.scss',
      styleDist = './assets/';

gulp.task('style',()=>{
    //sconsole.log('Are you looking for something');
    return gulp.src(styleSrc)
        .pipe(sourcemaps.init())
        .pipe(sass({
            'outputStyle':'expanded'
        }).on('error',sass.logError))
        //.pipe(concat('style.css'))
        //.pipe(rename({suffix:'.min'}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(styleDist))
        .pipe(browserSync.stream({
            reload:true
        }));
});

gulp.task('server',()=>{
    browserSync.init({
        server:'./',
        open:false
    });
    //gulp.watch(styleSrc,['style']);
});

// gulp.task('watch',['serve'],()=>{
//     gulp.watch(styleSrc,['style']);
// });