<style>
    :root {
        @if (getOption('app_color_design_type', 2) == 2)
        --primary: {{ getOption('app_primary_color', '#09a8f7') }};
        --secondary: {{ getOption('app_secondary_color', '#e5f7ff') }};
        --para-text: {{ getOption('app_text_color', '#686b8b') }};
        --primary-dark-text: {{ getOption('app_title_color', '#1f2224') }};
        --primary-light: {{ getOption('app_section_bg_color', '#ebf8ff') }};
        --inner-bg: {{ getOption('app_hero_footer_bg_color', '#040E17') }};
        @else
        --primary: #09a8f7;
        --secondary: #e5f7ff;
        --para-text: #686b8b;
        --primary-dark-text: #1f2224;
        --primary-light: #ebf8ff;
        --inner-bg: #040E17;
    @endif
    }
</style>
