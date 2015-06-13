var jshint = require( 'gulp-jshint' ),
    concat = require( 'gulp-concat' ),
    wrap = require( 'gulp-wrap' ),
    autopolyfiller = require('gulp-autopolyfiller'),
    uglify = require( 'gulp-uglify' ),
    merge = require( 'event-stream' ).merge,
    minimist = require( 'minimist' ),
    stylus = require( 'gulp-stylus' ),
    csscomb = require( 'gulp-csscomb' ),
    autoprefixer = require( 'gulp-autoprefixer' ),
    cssmin = require( 'gulp-cssmin' ),
    rename = require( 'gulp-rename' ),
    zip = require('gulp-zip'),
    ftp = require('gulp-ftp'),
    gulp = require( 'gulp-param' )( require( 'gulp' ), process.argv ),
    plumber = require('gulp-plumber'),
    newer = require('gulp-newer');

var phplint = require('phplint');

var known_options = {
    theme: '',
    plugin: '',
    submit_version: '',
    to_ftp: ''
};

var options = minimist( process.argv.slice(2), known_options );

gulp.task( 'default', function() {
    /**
     * Copy PHP files
     */
    gulp.src( '../development/php/**/*' )
        .pipe( newer( '../wellcrafted-support/' ) )
        .pipe( gulp.dest( '../wellcrafted-support/' ) );

    /**
     * Stylus
     */
    gulp.src( '../development/assets/stylus/style.styl' )
        .pipe( newer( '../wellcrafted-support/assets/css/style.css' ) )
        .pipe( stylus() )
        .pipe( csscomb() )
        .pipe( autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        } ) )
        .pipe( cssmin() )
        .pipe( gulp.dest( '../wellcrafted-support/assets/css/' ) );

    /**
     * Scripts
     */
    gulp.src( '../development/assets/javascript/script.js' )
        .pipe( newer( '../wellcrafted-support/assets/javascript/script.js' ) )
        .pipe( jshint() )
        .pipe( gulp.dest( '../wellcrafted-support/assets/javascript/' ) );
    
} );

gulp.task( 'copytotheme', function() {
    gulp.src( '../wellcrafted-support/**/*' )
        .pipe( newer( '/Users/kaok/Projects/msherstobitow/production/wp-content/plugins/wellcrafted-support/' ) )
        .pipe( gulp.dest('/Users/kaok/Projects/msherstobitow/production/wp-content/plugins/wellcrafted-support/') );
} );




















