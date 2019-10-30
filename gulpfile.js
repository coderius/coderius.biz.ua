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
var F_webDir = 'frontend/web/';

var F_sourseDir = F_webDir + 'source/',
    F_sassDir = F_sourseDir + 'sass/',
    F_sassMainFile = F_sassDir + 'main.scss';

var F_destCssDir = F_webDir + 'styles/css/',
    F_destCssMinDir = F_webDir + 'styles/css-min/';    

//    :nested
//    :compact
//    :expanded
//    :compressed
// Bootstrap scss source
var bootstrapSassSource = {
    in: './node_modules/bootstrap-sass/'
};

var bootstrapJsSource = {
    in: [
        './node_modules/bootstrap-sass/assets/javascripts'
    ]
};

var sassOptions = {
    outputStyle: 'nested',
    precison: 3,
    errLogToConsole: true,
    //пути ,доступные в папке sass 
    includePaths: [
        bootstrapSassSource.in + 'assets/stylesheets',//пути к ресурсам импорта прописанным в customBootstrapScssFile
        F_webDir + 'fonts/font-bootstrap3/fonts',
        F_webDir + 'fonts/font-awesome-4.7.0/scss',
        F_webDir + 'fonts/font-awesome-4.7.0/fonts'
    ]

};

//------------------------------------------------------------------------------
//                  компиляция sass
//------------------------------------------------------------------------------
gulp.task('front:compileSass', ['front:clean'], function(){
  return gulp
    .src([F_sassMainFile])
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
    .pipe(gulp.dest(F_destCssDir))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifyCss({processImport: false}))
//    .pipe(livereload(server))
    .pipe(gulp.dest(F_destCssMinDir))
    .pipe(notify("front:compileSass was compiled!"));
});

//
//gulp.task('front:combineMq', ['front:compileSass'], function () {
//    return gulp.src(F_destCssDir + '**/*.css')
//    .pipe(combineMq({
//        beautify: false
//    }))
//    .pipe(gulp.dest(F_destCssDir))
//    .pipe(notify("front:combineMq was compiled!"));
//});


// Очистка перед новой записью
gulp.task('front:clean', function() {
  return gulp.src([F_destCssDir, F_destCssMinDir], {read: false})
    .pipe(clean())
    .pipe(notify("front:clean was compiled!"));
});

//------------------------------------------------------------------------------
//Наблюдение за файлами. (запуск из консоли - gulp watch)
//------------------------------------------------------------------------------
// Default task - запускается командой gulp
gulp.task('default', ['front:clean'], function() {
    gulp.run('front:compileSass');
});


gulp.task('watch', function(){
    
    gulp.watch(F_sassDir + '**/*.scss', [
        'front:clean', 
        'front:compileSass', 
//        'front:combineMq'
                                    ]);
    
});

gulp.task('hello', function() {
  console.log(F_sassDir + '**/*.scss');
});