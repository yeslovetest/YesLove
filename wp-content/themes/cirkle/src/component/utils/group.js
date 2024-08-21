import router from '../../router/WP_Router';

const groupUtils = function (loggedUser, group, member = false) {
    const me = {};

    me.isGroupPublic = function () {
        return group.status === 'public';
    };

    me.isGroupCreator = function () {
        return group.creator.id === loggedUser.id;
    };

    me.isGroupAdmin = function () {
        return group.admins.some(admin => admin.id === loggedUser.id);
    };

    me.isGroupMod = function () {
        return group.mods.some(mod => mod.id === loggedUser.id);
    };

    me.isGroupMember = function () {
        for (const loggedUserGroup of loggedUser.groups) {
            if (loggedUserGroup.id === group.id) {
                return true;
            }
        }

        return false;
    };

    me.isBannedFromGroup = function () {
        return group.banned.some(member => member.id === loggedUser.id);
    };

    me.joinGroup = function (callback) {
        router.joinGroup({
            group_id: group.id,
            user_id: loggedUser.id
        }, callback);
    };

    me.leaveGroup = function (callback) {
        router.leaveGroup({
            group_id: group.id,
            user_id: loggedUser.id
        }, callback);
    };

    me.groupMemberIsCreator = function () {
        return group.creator.id === member.id;
    };

    me.groupMemberIsAdmin = function () {
        return group.admins.some(admin => admin.id === member.id);
    };

    me.groupMemberIsMod = function () {
        return group.mods.some(mod => mod.id === member.id);
    };

    me.groupMemberIsBanned = function () {
        return group.banned.some(bannedMember => bannedMember.id === member.id);
    };

    me.canPromoteMemberToAdmin = function () {
        return me.isGroupCreator();
    };

    me.canPromoteMemberToMod = function () {
        return me.isGroupCreator() || me.isGroupAdmin();
    };

    me.canDemoteMemberToMod = function () {
        return me.isGroupCreator();
    };

    me.canDemoteMemberToMember = function () {
        return me.isGroupCreator() || (me.isGroupAdmin() && !me.groupMemberIsCreator() && !me.groupMemberIsAdmin());
    };

    me.canRemoveGroupMember = function () {
        return me.isGroupCreator() || (me.isGroupAdmin() && !me.groupMemberIsCreator() && !me.groupMemberIsAdmin());
    };

    me.canBanMember = function () {
        return me.isGroupCreator() || (me.isGroupAdmin() && !me.groupMemberIsCreator() && !me.groupMemberIsAdmin());
    };

    me.canUnbanMember = function () {
        return me.isGroupCreator() || me.isGroupAdmin();
    };

    me.promoteGroupMemberToAdmin = function () {
        return router.promoteGroupMemberToAdmin({
            group_id: group.id,
            member_id: member.id
        });
    };

    me.promoteGroupMemberToMod = function () {
        return router.promoteGroupMemberToMod({
            group_id: group.id,
            member_id: member.id
        });
    };

    me.demoteGroupMemberToMod = function () {
        return router.demoteGroupMemberToMod({
            group_id: group.id,
            member_id: member.id
        });
    };

    me.demoteGroupMemberToMember = function () {
        return router.demoteGroupMemberToMember({
            group_id: group.id,
            member_id: member.id
        });
    };

    me.removeGroupMember = function () {
        return router.removeGroupMember({
            group_id: group.id,
            member_id: member.id
        });
    };

    me.banGroupMember = function () {
        return router.banGroupMember({
            group_id: group.id,
            member_id: member.id
        });
    };

    me.unbanGroupMember = function () {
        return router.unbanGroupMember({
            group_id: group.id,
            member_id: member.id
        });
    };

    return me;
};

export default groupUtils;