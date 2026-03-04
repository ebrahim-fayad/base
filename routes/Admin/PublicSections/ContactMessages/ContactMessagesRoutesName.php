<?php

namespace Routes\Admin\PublicSections\ContactMessages;

class ContactMessagesRoutesName
{
    public static function getNames(): array
    {
        return [
            // contact message routes name
            'all_contact_messages',
            'contact_messages.delete',
            'contact_messages.deleteAll',
            'contact_messages.show',
        ];
    }
}
