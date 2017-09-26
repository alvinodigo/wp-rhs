<?php


class RHSNotification_comments_in_post extends RHSNotification {

    /**
     * @param Object|Int $comment (ID ou objeto)
     */
    static function notify($comment) {

        $c = is_object($comment) ? $comment : get_comment($comment);
        
        // apenas cometarios aprovados e q não são de algum tipo especial, tipo pingback
        // e apenas comentários que foram feitos por algum usuário logado
        if (1 == $c->comment_approved && empty($c->comment_type) && !empty($c->user_id)) { // apenas cometarios aprovados e q não são de algum tipo especial, tipo pingback
            global $RHSNotifications;
            $RHSNotifications->add_notification(RHSNotifications::CHANNEL_COMMENTS, $c->comment_post_ID, self::get_name(), $c->comment_ID, $c->user_id);
        }

        
    }



    function text() {
        $comment_ID = $this->getObjectId();
        $c = get_comment($comment_ID);

        if($this->is_valid_post() && isset($c)) {
            $post_ID = $c->comment_post_ID;
            $user_id = $c->user_id;

            if($this->is_valid_user($user_id)) {
                $user = new RHSUser(get_userdata($user_id));

                return sprintf(
                    '<a href="%s"><strong>%s</strong></a> comentou no post <a href="%s"><strong>%s</strong></a>',
                    $user->get_link(),
                    $user->get_name(),
                    get_permalink($post_ID),
                    get_post_field( 'post_title', $post_ID )
                );
            }
        }
        
    }

    function image() {
        $comment_ID = $this->getObjectId();
        $c = get_comment($comment_ID);        
       
        if($this->is_valid_post() && isset($c)) {
            $post_ID = $c->comment_post_ID;
            $user_id = $c->user_id;

            if($this->is_valid_user($user_id)) {
                $user = new RHSUser(get_userdata($user_id));
                return $user->get_avatar();
            }
        }

        
    }

}
