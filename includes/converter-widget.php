<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Timezone Converter Widget.
 *
 * @since 1.0.0
 */
class Converter_Widget extends \Elementor\Widget_Base
{

	public function __construct($data = [], $args = null)
	{
		parent::__construct($data, $args);
		wp_register_script('tzc-widget-script', plugins_url('tz-converter/js/converter-widget.js'), ['elementor-frontend'], '1.0.0', true);

	}

	public function get_script_depends()
	{
		return ['tzc-widget-script'];
	}

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'tz-converter';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return esc_html__('Timezone Converter', 'tz-converter');
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-code';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['general'];
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords()
	{
		return ['timezone', 'converter', 'tz'];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls()
	{
		$zones = DateTimeZone::listIdentifiers();
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Initial Time', 'tz-converter'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'time',
			[
				'label' => esc_html__('Time', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('6:00 PM', 'tz-converter'),
				'label_block' => true,
			]
		);
		$this->add_control(
			'zone',
			[
				'label' => esc_html__('Timezone', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'UTC',
				'label_block' => true,
				'options' => array_combine($zones, $zones),
			]
		);
		$this->add_control(
			'format',
			[
				'label' => esc_html__('Datetime Format', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('M d, Y H:i:s A T', 'tz-converter'),
				'label_block' => true,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'labels_section',
			[
				'label' => esc_html__('Labels', 'tz-converter'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'from_text',
			[
				'label' => esc_html__('"From" Text', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('From', 'tz-converter'),
				'label_block' => true,
			]
		);
		$this->add_control(
			'to_text',
			[
				'label' => esc_html__('"To" Text', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('To', 'tz-converter'),
				'label_block' => true,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'elements_section',
			[
				'label' => esc_html__('HTML Tags', 'tz-converter'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'label_tag',
			[
				'label' => esc_html__('Label Tag', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => esc_html__('span', 'tz-converter'),
				'label_block' => true,
				'options' => [
					'span' => 'span',
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'div' => 'div',
					'p' => 'p',
				]
			]
		);
		$this->add_control(
			'datetime_tag',
			[
				'label' => esc_html__('Datetime Tag', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => esc_html__('span', 'tz-converter'),
				'label_block' => true,
				'options' => [
					'span' => 'span',
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'div' => 'div',
					'p' => 'p',
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'container_style_section',
			[
				'label' => esc_html__('Container', 'tz-converter'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Flex_Container::get_type(),
			[
				'name' => 'content_flex',
				'selector' => '{{WRAPPER}} .tz-converter__container',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'label_style_section',
			[
				'label' => esc_html__('Label', 'tz-converter'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'label_color',
			[
				'label' => esc_html__('Color', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tz-converter__from-label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tz-converter__to-label' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} .tz-converter__from-label, {{WRAPPER}} .tz-converter__to-label',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'label_shadow',
				'selector' => '{{WRAPPER}} .tz-converter__from-label, {{WRAPPER}} .tz-converter__to-label',
			]
		);
		$this->add_control(
			'label_spacing',
			[
				'label' => esc_html__('Spacing', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
					'rem' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .tz-converter__container > div' => 'display: flex; flex-direction: column; gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'input_style_section',
			[
				'label' => esc_html__('Input', 'tz-converter'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'input_color',
			[
				'label' => esc_html__('Color', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tz-converter__from-zone' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tz-converter__to-zone' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'selector' => '{{WRAPPER}} .tz-converter__from-zone, {{WRAPPER}} .tz-converter__to-zone',
			]
		);
		$this->add_control(
			'input_width',
			[
				'label' => esc_html__('Width', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
					'rem' => [
						'min' => 0,
						'max' => 100,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}} .tz-converter__from-zone' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tz-converter__to-zone' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'datetime_style_section',
			[
				'label' => esc_html__('Datetime', 'tz-converter'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'datetime_color',
			[
				'label' => esc_html__('Color', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tz-converter__from-datetime' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tz-converter__to-datetime' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'datetime_typography',
				'selector' => '{{WRAPPER}} .tz-converter__from-datetime, {{WRAPPER}} .tz-converter__to-datetime',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'datetime_shadow',
				'selector' => '{{WRAPPER}} .tz-converter__from-datetime, {{WRAPPER}} .tz-converter__to-datetime',
			]
		);
		$this->add_control(
			'datetime_spacing',
			[
				'label' => esc_html__('Spacing', 'tz-converter'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
					'rem' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .tz-converter__from-container' => 'display: flex; align-items: center; gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tz-converter__to-container' => 'display: flex; align-items: center; gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$from_date = new DateTime(current_time('Y-m-d ') . $settings['time'], new DateTimeZone($settings['zone']));
?>
		<div class='tz-converter__container e-container elementor-element'>
			<input class='tz-converter__data' type='hidden' value='<?php echo $from_date->format(DateTime::ATOM); ?>' />
			<div class='tz-converter__from'>
				<<?php echo $settings['label_tag']; ?> class='tz-converter__from-label'><?php echo $settings['from_text']; ?></<?php echo $settings['label_tag']; ?>>
				<div class='tz-converter__from-container'>
					<input class='tz-converter__from-zone' type='text' readonly value='<?php echo $settings['zone']; ?>' />
					<<?php echo $settings['datetime_tag']; ?> class='tz-converter__from-datetime'><?php echo $from_date->format($settings['format']); ?></<?php echo $settings['datetime_tag']; ?>>
				</div>
			</div>
			<div class='tz-converter__to'>
				<<?php echo $settings['label_tag']; ?> class='tz-converter__to-label'><?php echo $settings['to_text']; ?></<?php echo $settings['label_tag']; ?>>
				<div class='tz-converter__to-container'>
					<select class='tz-converter__to-zone'>
						<?php echo wp_timezone_choice($settings['zone']); ?>
					</select>
					<<?php echo $settings['datetime_tag']; ?> class='tz-converter__to-datetime'><?php echo $from_date->format($settings['format']); ?></<?php echo $settings['datetime_tag']; ?>>
				</div>
			</div>
		</div>
<?php
	}
}
