<?php
/**
 * Entidade do Usuário
 * Class RHSUser
 */
class RHSUser {

    private $id;
    private $avatar;
    private $avatar_url;
    private $login;
    private $name;
    private $email;
    private $first_name;
    private $last_name;
    private $url;
    private $description;
    private $formation;
    private $date_registered;
    private $city_id;
    private $state_id;
    private $city;
    private $state;
    private $state_uf;
    private $interest;
    private $link;
    private $user_object;
    private $state_city_object;
    private $role;
    private $is_admin;
    private $user_role;
    private $links;

    /**
     * RHSUser constructor.
     *
     * @param WP_User $user
     */
    function __construct(WP_User $user) {

        if(!$user){
            return;
        }

        $this->id = $user->ID;
        $this->user_object = $user;
    }

    /**
     * @return int
     */
    function get_id(){
        return $this->id;
    }

    /**
     * @return string
     */
    function get_login(){

        if($this->login || !$this->id){
            return $this->login;
        }

        return $this->login = $this->user_object->user_login;
    }

    /**
     * @return false|string
     */
    function get_avatar(){

        if($this->avatar || !$this->id){
            return $this->avatar;
        }

        return $this->avatar =  get_avatar($this->id);
    }

    /**
     * @return false|string
     */
    function get_avatar_url(){

        if($this->avatar_url || !$this->id){
            return $this->avatar_url;
        }

        $avatar = esc_attr( get_the_author_meta( 'rhs_avatar', $this->id ));

        if ( ! empty( $avatar ) ) {
            $avatar = get_site_url() . '/../' . $avatar;
        }

        return $this->avatar_url = $avatar;
    }

    /**
     * @return string
     */
    function get_name(){

        if($this->name || !$this->id){
            return $this->name;
        }

        return $this->name = $this->user_object->display_name;
    }

    /**
     * @return string
     */
    function get_url(){

        if($this->url || !$this->id){
            return $this->url;
        }

        return $this->url = $this->user_object->user_url;
    }

    /**
     * @return string
     */
    function get_email(){

        if($this->email || !$this->id){
            return $this->email;
        }

        return $this->email = $this->user_object->user_email;
    }

    /**
     * @return string
     */
    function get_first_name(){

        if($this->first_name || !$this->id){
            return $this->first_name;
        }

        return $this->first_name = $this->user_object->first_name;

    }

    /**
     * @return string
     */
    function get_last_name(){

        if($this->last_name || !$this->id){
            return $this->last_name;
        }

        return $this->last_name = $this->user_object->last_name;
    }

    /**
     * @return mixed
     */
    function get_description(){

        if($this->description || !$this->id){
            return $this->description;
        }

        return $this->description = $this->user_object->description;
    }

    /**
     * @return mixed
     */
    function get_formation(){
        if($this->formation || !$this->id){
            return $this->formation;
        }

        return $this->formation =  get_the_author_meta( 'rhs_formation', $this->id );

    }

    /**
     * @return mixed
     */
    function get_interest(){

        if($this->interest || !$this->id){
            return $this->interest;
        }

        return $this->interest =  get_the_author_meta( 'rhs_interest', $this->id );
    }

    /**
     * @param string $format
     *
     * @return false|string
     */
    function get_date_registered($format = 'd/m/Y'){

        if(!$this->id){
            return $this->date_registered;
        }

        return date($format, strtotime($this->user_object->date_registered));

    }

    private function get_state_city_object(){

        if($this->state_city_object || !$this->id){
            return $this->state_city_object;
        }

        return $this->state_city_object = get_user_ufmun($this->id);

    }

    /**
     * @return int
     */
    function get_city_id(){

        if($this->city_id || !$this->id || !$this->get_state_city_object()){
            return $this->city_id;
        }

        $object = $this->get_state_city_object();

        return $this->city_id = !empty($object['mun']['id']) ? $object['mun']['id'] : '';
    }

    /**
     * @return int
     */
    function get_state_id(){
        if($this->state_id || !$this->id || !$this->get_state_city_object()){
            return $this->state_id;
        }

        $object = $this->get_state_city_object();

        return $this->state_id = !empty($object['uf']['id']) ? $object['uf']['id'] : '';

    }

    /**
     * @return string
     */
    function get_city(){
        if($this->city || !$this->id || !$this->get_state_city_object()){
            return $this->city;
        }

        $object = $this->get_state_city_object();

        return $this->city = !empty($object['mun']['nome']) ? $object['mun']['nome'] : '';

    }

    /**
     * @return string
     */
    function get_state(){
        if($this->state || !$this->id || !$this->get_state_city_object()){
            return $this->state;
        }

        $object = $this->get_state_city_object();

        return $this->state = !empty($object['uf']['nome']) ? $object['uf']['nome'] : '';
    }

    /**
     * @return string
     */
    function get_state_uf(){
        if($this->state_uf || !$this->id || !$this->get_state_city_object()){
            return $this->state_uf;
        }

        $object = $this->get_state_city_object();

        return $this->state_uf = !empty($object['uf']['sigla']) ? $object['uf']['sigla'] : '';

    }

    /**
     * @return string
     */
    function get_link(){

        if($this->link || !$this->id){
            return $this->link;
        }

        return $this->link =  esc_url(get_author_posts_url($this->id));
    }

    /**
     * @param $comunityID
     *
     * @return RHSComunity
     */
    function get_comunity($comunityID){
        return new RHSComunity(get_term($comunityID), $this->user_object);
    }

    function get_role(){
        if($this->role || !$this->id){
            return $this->role;
        }

        return $this->role = ($this->user_object->roles) ? current($this->user_object->roles) : '';
    }

    /**
     * @return bool
     */
    function is_admin(){

        if($this->is_admin || !$this->id){
            return $this->is_admin;
        }

        return $this->is_admin = ($this->get_role() == 'administrator' || $this->get_role() == 'editor');
    }

    /**
     * Exibe links de usuário
     *
     * @param int $user_id
     * @return void
     */
    function show_user_links_to_edit($user_id){
        !($user_id) ? $user_id = $this->get_id() : '' ;
        $links = get_user_meta($user_id, 'rhs_links', true);
        $count = 1;
        $link_to_delete = '<a title="Remover link" class="remove-link" href="javascript:;"><i class="fa fa-remove"></i></a>';

        !($user_id) ? $user_id = $this->get_id() : '' ;
        $links = get_user_meta($user_id, 'rhs_links', true);
        
        if($links){
            foreach ($links as $key=>$value){
                if ($count%2 == 1) { echo "<div class='row links'>"; }
                ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="edit-nome">
                        <?php echo !($key % 2) ? "Título" : "URL"; ?>
                        </label>
                        <input class="form-control" type="text" name="links[]" size="60" maxlength="254" value="<?php echo $value ?>">
                        <?php echo !($key % 2) ? '' : $link_to_delete; ?>
                    </div>
                </div>
            
                <?php
                if ($count%2 == 0) { echo "</div>"; }
                $count++;
            }
            if ($count%2 != 1) echo "</div>";
        } elseif(is_admin()) {
            echo '
                <div class="row links">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="edit-nome">
                            Título
                            </label>
                            <input class="form-control" type="text" name="links[]" size="60" maxlength="254" value="">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="edit-nome">
                            URL
                            </label>
                            <input class="form-control" type="text" name="links[]" size="60" maxlength="254" value="">
                            '. $link_to_delete .'
                        </div>
                    </div>
                </div>
            ';
        }
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="help-block">
                        <a title="Adicionar Link" href="javascript:;"
                        class="btn btn-info js-add-link">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        ';
    }
}