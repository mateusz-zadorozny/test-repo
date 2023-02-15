<?php

namespace FluentFormPro\Components;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Services\FormBuilder\BaseFieldManager;
use FluentForm\Framework\Helpers\ArrayHelper;

class SaveProgressButton extends BaseFieldManager
{
    public function __construct()
    {
        parent::__construct(
            'save_progress_button',
            'Save & Resume',
            ['save', 'button', 'progress'],
            'advanced'
        );
    }
    
    public function pushFormInputType($types)
    {
        return $types;
    }
    
    function getComponent()
    {
        return [
            'index'          => 15,
            'element'        => $this->key,
            'attributes'     => [
                'class' => '',
            ],
            'settings'       => [
                'button_style'       => 'default',
                'button_size'        => 'md',
                'align'              => 'left',
                'container_class'    => '',
                'current_state'      => 'normal_styles',
                'background_color'   => 'rgb(64, 158, 255)',
                'color'              => 'rgb(255, 255, 255)',
                'hover_styles'       => (object)[
                    'backgroundColor' => '#ffffff',
                    'borderColor'     => '#409EFF',
                    'color'           => '#409EFF',
                    'borderRadius'    => '',
                    'minWidth'        => '100%'
                ],
                'normal_styles'      => (object)[
                    'backgroundColor' => '#409EFF',
                    'borderColor'     => '#409EFF',
                    'color'           => '#ffffff',
                    'borderRadius'    => '',
                    'minWidth'        => ''
                ],
                'button_ui'          => (object)[
                    'text'    => 'Save & Resume',
                    'type'    => 'default',
                    'img_url' => ''
                ],
                'conditional_logics' => []
            ],
            'editor_options' => [
                'title'      => $this->title,
                'icon_class' => 'dashicons dashicons-arrow-right-alt',
                'template'   => 'customButton'
            ],
        ];
    }
    
    public function pushConditionalSupport($conditonalItems)
    {
        return $conditonalItems;
    }
    
    
    public function getGeneralEditorElements()
    {
        return [
            'btn_text',
            'button_ui',
            'button_style',
            'button_size',
            'align',
        ];
    }
    
    public function getAdvancedEditorElements()
    {
        return [
            'container_class',
            'class',
            'conditional_logics',
        ];
    }
    
    public function render($data, $form)
    {
        
        $elementName = $data['element'];
        $data = apply_filters('fluentform_rendering_field_data_' . $elementName, $data, $form);
        wp_localize_script('form-save-progress','form_state_save_vars',[
            'source_url' => home_url($_SERVER['REQUEST_URI']),
        ]);
        wp_enqueue_script('form-save-progress');
        add_filter('fluentform_form_class', function ($formClass){
            return $formClass .= ' ff-form-has-save-progress';
        });
        
        $btnStyle = ArrayHelper::get($data['settings'], 'button_style');
        
        $btnSize = 'ff-btn-';
        $btnSize .= isset($data['settings']['button_size']) ? $data['settings']['button_size'] : 'md';
        $oldBtnType = isset($data['settings']['button_style']) ? '' : ' ff-btn-primary ';
        
        $align = 'ff-el-group ff-text-' . @$data['settings']['align'];
        
        $btnClasses = [
            'ff-btn ff-btn-save-progress',
            $oldBtnType,
            $btnSize,
            $data['attributes']['class']
        ];
        
        if($btnStyle == 'no_style') {
            $btnClasses[] = 'ff_btn_no_style';
        } else {
            $btnClasses[] = 'ff_btn_style';
        }
        
        $data['attributes']['class'] = trim(implode(' ', array_filter($btnClasses)));
        
        if($tabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex()) {
            $data['attributes']['tabindex'] = $tabIndex;
        }
        $styles = '';
        if (ArrayHelper::get($data, 'settings.button_style') == '') {
            $data['attributes']['class'] .= ' wpf_has_custom_css';
            // it's a custom button
            $buttonActiveStyles = ArrayHelper::get($data, 'settings.normal_styles', []);
            $buttonHoverStyles = ArrayHelper::get($data, 'settings.hover_styles', []);
            
            $activeStates = '';
            foreach ($buttonActiveStyles as $styleAtr => $styleValue) {
                if (!$styleValue) {
                    continue;
                }
                if ($styleAtr == 'borderRadius') {
                    $styleValue .= 'px';
                }
                $activeStates .= ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $styleAtr)), '_') . ':' . $styleValue . ';';
            }
            if ($activeStates) {
                $styles .= 'form.fluent_form_' . $form->id . ' .wpf_has_custom_css.ff-btn-save-progress { ' . $activeStates . ' }';
            }
            $hoverStates = '';
            foreach ($buttonHoverStyles as $styleAtr => $styleValue) {
                if (!$styleValue) {
                    continue;
                }
                if ($styleAtr == 'borderRadius') {
                    $styleValue .= 'px';
                }
                $hoverStates .= ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $styleAtr)), '-') . ':' . $styleValue . ';';
            }
            if ($hoverStates) {
                $styles .= 'form.fluent_form_' . $form->id . ' .wpf_has_custom_css.ff-btn-save-progress:hover { ' . $hoverStates . ' } ';
            }
        } else if($btnStyle != 'no_style') {
            $styles .= 'form.fluent_form_' . $form->id . ' .ff-btn-save-progress { background-color: ' . ArrayHelper::get($data, 'settings.background_color') . '; color: ' . ArrayHelper::get($data, 'settings.color') . '; }';
        }
        
        $atts = $this->buildAttributes($data['attributes']);
        $hasConditions = $this->hasConditions($data) ? 'has-conditions ' : '';
        $cls = trim($align . ' ' . $data['settings']['container_class'] . ' ' . $hasConditions);
        
        $html = "<div class='{$cls} ff_submit_btn_wrapper ff_submit_btn_wrapper_custom'>";
        
        // ADDED IN v1.2.6 - updated in 1.4.4
        if (isset($data['settings']['button_ui'])) {
            if ($data['settings']['button_ui']['type'] == 'default') {
                $html .= '<button ' . $atts . '>' . $data['settings']['button_ui']['text'] . '</button>';
            } else {
                $html .= "<button class='ff-btn-save-progress' type='submit'><img style='max-width: 200px;' src='{$data['settings']['button_ui']['img_url']}' alt='Submit Form'></button>";
            }
        } else {
            $html .= '<button ' . $atts . '>' . $data['settings']['btn_text'] . '</button>';
        }
        
        if ($styles) {
            $html .= '<style>' . $styles . '</style>';
        }
        
        $html .= '</div>';
        
        echo apply_filters('fluentform_rendering_field_html_' . $elementName, $html, $data, $form);
    }
}

