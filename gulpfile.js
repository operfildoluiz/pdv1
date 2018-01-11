var gulp = require("gulp");
var sass = require("gulp-sass");
var uglify = require('gulp-uglify');
// var cssmin = require('gulp-cssmin');
// var rename = require('gulp-rename');
var pump = require('pump');

gulp.task('compile',function(cb){
  console.log('========> Compilando SCSS...');
  pump([
    gulp.src("./templates/assets/**/*.scss"),
    sass(),
    gulp.dest('./public/css')
    ],
    cb
    );
});

// gulp.task('minify',['compile'], function(cb) {
//   console.log('========> Minificando CSS...');
//   pump([
//     gulp.src('./public/css/*.css'),
//     cssmin(),
//     rename({
//       suffix: '.min'
//     }),
//     gulp.dest('./public/css')
//     ],
//     cb
//     );
// });

gulp.task('minify-js', function (cb) {
  console.log('========> Minificando JS...');
  pump([
    gulp.src('./templates/assets/**/*.js'),
    uglify(),
    // rename({
    //   suffix: '.min'
    // }),
    gulp.dest('./public/js')
    ],
    cb
    );
});

gulp.task('default', function(){
  gulp.watch('./templates/assets/**/*.scss',['compile']);
  gulp.watch('./templates/assets/**/*.js',['minify-js']);
});
