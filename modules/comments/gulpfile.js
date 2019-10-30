var gulp = require('gulp');
var sass = require('gulp-sass');// подключаем gulp-sass
var minifyCss = require('gulp-clean-css');//минификация css
var rename = require('gulp-rename');
var notify = require("gulp-notify");
var autoprefixer = require('gulp-autoprefixer');
var clean = require('gulp-clean');
var combineMq = require('gulp-combine-mq');

//==============================================================================
//**************************  FrontEnd  ****************************************
//==============================================================================
//ПУТИ

var sorseDir = 'widgets/commentsBlock/assets/styles/scss/';
var sourceFile = sorseDir + 'comments.scss';
var resDir = 'widgets/commentsBlock/assets/styles/css/';
 



var sassOptions = {
    outputStyle: 'expanded',
    precison: 3,
    errLogToConsole: true,
    //пути ,доступные в папке sass 
    includePaths: [
        
    ]

};

//------------------------------------------------------------------------------
//                  компиляция sass
//------------------------------------------------------------------------------
gulp.task('front:compileSass', ['front:clean'], function(){
  return gulp
    .src([sourceFile])
    //.pipe(sourcemaps.init())
    .pipe(sass(sassOptions).on('error', sass.logError))
    //.pipe(sourcemaps.write('./maps'))
    .pipe(autoprefixer({
            browsers: ['last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'],
            cascade: false
        }))
    .pipe(combineMq({
        beautify: false
    }))    
    .pipe(gulp.dest(resDir))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifyCss({processImport: false}))
    .pipe(gulp.dest(resDir))
//    .pipe(livereload(server))
    .pipe(notify("front:compileSass was compiled!"));
});



// Очистка перед новой записью
gulp.task('front:clean', function() {
  return gulp.src([resDir], {read: false})
    .pipe(clean())
    .pipe(notify("front:clean was compiled!"));
});

//------------------------------------------------------------------------------
//Наблюдение за файлами. (запуск из консоли - gulp watch)
//------------------------------------------------------------------------------



gulp.task('watch', function(){
    
    gulp.watch(sorseDir + '**/*.scss', [
        'front:clean', 
        'front:compileSass', 
//        'front:combineMq'
                                    ]);
    
});

gulp.task('hello', function() {
  console.log(sorseDir + '**/*.scss');
});