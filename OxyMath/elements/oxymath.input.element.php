<?php

class OxyMathInput extends OxyEl {

    function init() {
        // Do some initial things here.
    }

    function afterInit() {
        // Do things after init, like remove apply params button and remove the add button.
        $this->removeApplyParamsButton();
        // $this->removeAddButton();
    }

    function name() {
        return 'Oxy Math';
    }
    
    function slug() {
        return "oxymath";
    }

    function icon() {
        // Path to icon here.
        return plugin_dir_url(__FILE__) . 'input.svg';
    }

    function button_place() {
         //
    }

    function button_priority() {
        // return 9;
    }

    
    function render($options, $defaults, $content) {
        // Output here. strtolower(preg_replace('/\s*/', '', $zname_clean))
        $label_ = isset( $options['coda_label_value'] ) ? esc_attr($options['coda_label_value']) : "";
        $label = strtolower(preg_replace('/\s*/', '', $label_));
        $ref = isset( $options['coda_input_id'] ) ? esc_attr($options['coda_input_id']) : "";
        $ref =  strtolower(preg_replace('/\s*/', '', $ref));
        $advanced_style = ( $options['input_toggle_advanced_style'] === 'enabled') ? "mathform-advanced-style" : "";
        $label_visible = isset( $options['label_visibility'] ) ? esc_attr($options['label_visibility']) : "";
        $track_visible = isset( $options['input_track_visibility'] ) ? esc_attr($options['input_track_visibility']) : "";
        $min = isset( $options['coda_input_min'] ) ? esc_attr($options['coda_input_min']) : "1";
        $max = isset( $options['coda_input_max'] ) ? esc_attr($options['coda_input_max']) : "100";
        $val = isset( $options['coda_input_val'] ) ? esc_attr($options['coda_input_val']) : "50";
        $step= isset( $options['coda_input_step'] ) ? esc_attr($options['coda_input_step']) : "1";


            ?>
            <label class="matform-input-label matform-label-is-<?php echo $label_visible; ?>" for="<?php echo $label; ?>"><?php echo $label_; ?></label>
        <?php
        if($options['input_types'] === 'number'){
            ?>
            <input class="matform-element matform-track-is-<?php echo $track_visible; ?>" data-mathref="<?php echo $ref; ?>" id="<?php echo $label; ?>" name="<?php echo $label; ?>" type="number" value="<?php echo $val; ?>" min="<?php echo $min; ?>" max="<?php echo $max; ?>" step="<?php echo $step; ?>" onchange="oxymath()">
        <?php
        }
        else if($options['input_types'] === 'range'){
            ?>
            <input class="matform-element <?php echo $advanced_style; ?>" data-mathref="<?php echo $ref; ?>"  type="range"  value="<?php echo $val; ?>" min="<?php echo $min; ?>" max="<?php echo $max; ?>" step="<?php echo $step; ?>" id="<?php echo $label; ?>" name="<?php echo $label; ?>" onchange="oxymath()">
            <?php
            }

        
    }

    function controls() {
        //reference for calculation
        $inputId = $this->addOptionControl(
            array(
                "type" => 'textfield', // types: textfield, dropdown, checkbox, buttons-list, measurebox, slider-measurebox, colorpicker, icon_finder, mediaurl
				"name" => 'Unique Reference (**required)',
				"slug" => 'coda_input_id'
            )
        )->rebuildElementOnChange();
        $inputId->setDefaultValue('calculation1');
        
        $input_type = $this->addOptionControl(
            array(
                "type" => 'buttons-list', // types: textfield, dropdown, checkbox, buttons-list, measurebox, slider-measurebox, colorpicker, icon_finder, mediaurl
				"name" => 'Input type',
				"slug" => 'input_types',
                "default" => "number"
            )
        )->rebuildElementOnChange();

        $input_type->setValue(
            array(
                'number' => 'number',
                "range" => 'range'
            )
        );
        
        $labelControl = $this->addOptionControl(
            array(
                "type" => 'textfield', // types: textfield, dropdown, checkbox, buttons-list, measurebox, slider-measurebox, colorpicker, icon_finder, mediaurl
				"name" => 'Label',
				"slug" => 'coda_label_value'
            )
        )->rebuildElementOnChange();
        

        $labelMin = $this->addOptionControl(
            array(
                "type" => 'textfield', // types: textfield, dropdown, checkbox, buttons-list, measurebox, slider-measurebox, colorpicker, icon_finder, mediaurl
				"name" => 'Min value',
				"slug" => 'coda_input_min'
            )
        )->rebuildElementOnChange();
        $labelMin->setDefaultValue('1');

        $labelMax = $this->addOptionControl(
            array(
                "type" => 'textfield', // types: textfield, dropdown, checkbox, buttons-list, measurebox, slider-measurebox, colorpicker, icon_finder, mediaurl
				"name" => 'Max value',
				"slug" => 'coda_input_max'
            )
        )->rebuildElementOnChange();
        $labelMax->setDefaultValue('100');
        $labelInital = $this->addOptionControl(
            array(
                "type" => 'textfield', // types: textfield, dropdown, checkbox, buttons-list, measurebox, slider-measurebox, colorpicker, icon_finder, mediaurl
				"name" => 'Initial Value',
				"slug" => 'coda_input_val'
            )
        )->rebuildElementOnChange();
        $labelInital->setDefaultValue('50');
        $labelStep = $this->addOptionControl(
            array(
                "type" => 'textfield', // types: textfield, dropdown, checkbox, buttons-list, measurebox, slider-measurebox, colorpicker, icon_finder, mediaurl
				"name" => 'Step',
				"slug" => 'coda_input_step'
            )
        )->rebuildElementOnChange();
        $labelStep->setDefaultValue('1');

        $label_visibility = $this->addOptionControl(
            array(
                "type" => 'buttons-list', // types: textfield, dropdown, checkbox, buttons-list, measurebox, slider-measurebox, colorpicker, icon_finder, mediaurl
                "name" => 'Label visibility',
                "slug" => 'label_visibility',
                "default" => "visible"
            )
        )->rebuildElementOnChange();

        $label_visibility->setValue(
            array(
                'visible' => 'visible',
                'hidden' => 'hidden'
            )
        )->rebuildElementOnChange();

        $input_style = $this->addControlSection("input_style", __("Input Colors"), "assets/icon.png", $this);
        $input_style->addStyleControl(
            array( 
                    "name" => __('Accent Color  (*range type)'),
                    "selector" => ".matform-element",
                    "property" => 'accent-color',
                    "control_type" => "colorpicker"
                )
        );
        $input_style->addStyleControl(
            array( 
                    "name" => __('Color'),
                    "selector" => ".matform-element",
                    "property" => 'color',
                    "control_type" => "colorpicker"
                )
        );
        $input_style->addStyleControl(
            array( 
                    "name" => __('Background Color'),
                    "selector" => ".matform-element",
                    "property" => 'background-color',
                    "control_type" => "colorpicker"
                )
        );
        $this->borderSection(
            __("Input Border"),
            '.matform-element',
            $this
        );
        $spacing_section = $this->addControlSection("spacing", __("Input Padding"),  'input.svg', $this);
        $spacing_section->addPreset(
            "padding",
            "input_item_padding",
            __("Item Padding"),
            ".matform-element"
        )->whiteList();
        $track_visibility = $this->addOptionControl(
            array(
                "type" => 'buttons-list', // types: textfield, dropdown, checkbox, buttons-list, measurebox, slider-measurebox, colorpicker, icon_finder, mediaurl
                "name" => 'Input arrow visibility (*number type)',
                "slug" => 'input_track_visibility',
                "default" => "visible"
            )
        )->rebuildElementOnChange();

        $track_visibility->setValue(
            array(
                'visible' => 'visible',
                'hidden' => 'hidden'
            )
        );
       
    }
    function defaultCSS() {

        return file_get_contents(__DIR__.'/'.basename(__FILE__, '.php').'.css');
 
    }
    
}

new OxyMathInput();
