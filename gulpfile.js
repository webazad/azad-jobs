const gulp = require('gulp'),
      rename = require('gulp-rename');
      sass = require('gulp-sass'),
      uglify = require('gulp-uglify'),
      sourcemaps = require('gulp-sourcemaps')

const styleSrc = './assets/sass/**/*.scss',
      styleDist = './assets/';

gulp.task('style',()=>{
    //console.log('Are you looking for something');
    return gulp.src(styleSrc)
        .pipe(sourcemaps.init())
        .pipe(sass({
            'outputStyle':'expanded'
        }).on('error',sass.logError))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(styleDist))
        .pipe(rename({suffix:'.min'}))
        .pipe(gulp.dest(styleDist));
});

gulp.task('js',()=>{
    return gulp.src('./assets/sass/**/*.js')
    .pipe(gulp.dest('./assets'))
    .pipe(uglify())
    .pipe(rename({suffix:'.min'}))
    .pipe(gulp.dest('./assets'));
});